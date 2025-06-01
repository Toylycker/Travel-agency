<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\Day;
use App\Models\Image;
use App\Models\Price;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Gallery;
use Illuminate\Http\UploadedFile;

class TourService extends BaseService
{
    public function __construct(Tour $tour)
    {
        parent::__construct($tour);
    }

    public function createNewTour(array $data): Tour
    {
        return DB::transaction(function () use ($data) {
            $tourCoreData = $this->prepareTourCoreData($data);
            // Create tour without main_image first to get an ID for image naming
            $tour = Tour::create(array_merge($tourCoreData, ['main_image' => 'placeholder.jpg'])); // Placeholder or null

            if (!empty($data['main_image_file']) && $data['main_image_file'] instanceof UploadedFile) {
                $tour->main_image = $this->handleMainImageUpload($tour, $data['main_image_file']);
                $tour->save(); // Save tour again with the actual main_image name
            }

            if (!empty($data['additional_images_files']) && is_array($data['additional_images_files'])) {
                $this->handleAdditionalImagesUpload($tour, $data['additional_images_files']);
            }

            $this->syncNotes($tour, $data['included'] ?? null, $data['non_included'] ?? null);

            if (isset($data['days']) && is_array($data['days'])) {
                if ($data['is_public']) {
                    $this->syncDaysForPublicTour($tour, $data['days']);
                    if (isset($data['detailedPrices'])) {
                        $this->syncPricesForPublicTour($tour, $data['detailedPrices']);
                    }
                } else { // Private Tour
                    $this->syncDaysForPrivateTour($tour, $data['days']);
                }
            }
            return $tour->fresh(); // Return fresh model with all relations
        });
    }

    public function updateExistingTour(Tour $tour, array $data): Tour
    {
        return DB::transaction(function () use ($tour, $data) {
            $tourCoreData = $this->prepareTourCoreData($data);
            $tour->fill($tourCoreData);

            if (!empty($data['main_image_file']) && $data['main_image_file'] instanceof UploadedFile) {
                $tour->main_image = $this->handleMainImageUpload($tour, $data['main_image_file'], $tour->main_image);
            }
            // If you want to allow removing main_image by passing null or an empty string for main_image_file:
            // else if (array_key_exists('main_image_file', $data) && $data['main_image_file'] === null && $tour->main_image) {
            //     Storage::delete('public/tours/' . $tour->main_image);
            //     $tour->main_image = null;
            // }

            $tour->save();

            if (!empty($data['additional_images_files']) && is_array($data['additional_images_files'])) {
                 // For update, decide on strategy: append, or sync (delete old, add new)
                 // PrivateTourController appends, TourController (putImages) syncs.
                 // Let's provide sync for general purpose, can be called specifically.
                 // If 'additional_images_strategy' => 'append' is passed in $data, we can append.
                if(isset($data['additional_images_sync_strategy']) && $data['additional_images_sync_strategy'] === 'sync'){
                    $this->syncAdditionalImages($tour, $data['additional_images_files']);
                } else {
                    $this->handleAdditionalImagesUpload($tour, $data['additional_images_files']); // Default append
                }
            }

            $this->syncNotes($tour, $data['included'] ?? null, $data['non_included'] ?? null);

            if (isset($data['days']) && is_array($data['days'])){
                if ($data['is_public']) {
                    $this->syncDaysForPublicTour($tour, $data['days']);
                    if (isset($data['detailedPrices'])) {
                        $this->syncPricesForPublicTour($tour, $data['detailedPrices']);
                    }
                } else { // Private Tour
                    $this->syncDaysForPrivateTour($tour, $data['days']);
                }
            }
            return $tour->fresh();
        });
    }

    private function prepareTourCoreData(array $data): array
    {
        return [
            'name' => $data['name'],
            'name_cn' => $data['name_cn'] ?? null,
            'body' => $data['body'],
            'body_cn' => $data['body_cn'] ?? null,
            'map' => $data['map'] ?? null,
            'total_days' => $data['total_days'],
            'tour_prices' => $data['prices'] ?? ($data['tour_prices'] ?? '0'),
            'discount_percent' => $data['discount_percent'] ?? 0,
            'discount_datetime_start' => $data['discount_datetime_start'] ?? null,
            'discount_datetime_end' => $data['discount_datetime_end'] ?? null,
            'viewed' => $data['viewed'] ?? 0,
            'recommended' => $data['recommended'] ?? false,
            'active' => $data['active'] ?? true,
            'sort_order' => $data['sort_order'] ?? null,
            'is_public' => $data['is_public'] ?? true,
        ];
    }

    private function handleMainImageUpload(Tour $tour, UploadedFile $imageFile, ?string $oldImageNameToDelete = null): ?string
    {
        if ($oldImageNameToDelete && Storage::exists('public/tours/' . $oldImageNameToDelete)) {
            Storage::delete('public/tours/' . $oldImageNameToDelete);
        }
        $resized = Gallery::make($imageFile)->fit(1400, 800)->encode('jpg', 100);
        // Use tour ID in name if available, Str::random if ID is not set (e.g. before initial save)
        $imageNamePrefix = $tour->id ? Str::random(10) . '-' . $tour->id : Str::random(10);
        $newImageName = $imageNamePrefix . '.' . $imageFile->getClientOriginalExtension();
        Storage::put('public/tours/' . $newImageName, (string) $resized);
        return $newImageName;
    }

    // Appends images
    private function handleAdditionalImagesUpload(Tour $tour, array $imageFiles): void
    {
        foreach ($imageFiles as $imageFile) {
            if (!$imageFile instanceof UploadedFile) continue;
            $resized = Gallery::make($imageFile)->fit(1280, 1024)->encode('jpg', 100);
            $newImageName = Str::random(10) . '-' . $tour->id . '.' . $imageFile->getClientOriginalExtension();
            Storage::put('public/tours/' . $newImageName, (string) $resized);
            Image::create([
                'name' => $newImageName,
                'imageable_id' => $tour->id,
                'imageable_type' => \App\Models\Tour::class
            ]);
        }
    }

    // Deletes all existing images for the tour and adds new ones.
    public function syncAdditionalImages(Tour $tour, array $imageFiles): void
    {
        $existingImages = $tour->images;
        foreach ($existingImages as $img) {
            Storage::delete('public/tours/' . $img->name);
            $img->delete(); // Deletes the Image model record
        }
        $this->handleAdditionalImagesUpload($tour, $imageFiles); // Re-use to add new ones
    }

    public function syncNotes(Tour $tour, ?array $includedNoteIds, ?array $nonIncludedNoteIds): void
    {
        $tour->notes()->detach();
        if (!empty($includedNoteIds)) {
            foreach ($includedNoteIds as $noteId) {
                $tour->notes()->attach($noteId, ['status' => 'included']);
            }
        }
        if (!empty($nonIncludedNoteIds)) {
            foreach ($nonIncludedNoteIds as $noteId) {
                $tour->notes()->attach($noteId, ['status' => 'non included']);
            }
        }
    }

    public function syncDaysForPrivateTour(Tour $tour, array $daysData): void
    {
        $currentDayIds = $tour->days()->pluck('id')->toArray();
        $processedDayIds = [];

        foreach ($daysData as $dayInput) {
            $day = null;
            if (!empty($dayInput['id'])) {
                $day = Day::where('id', $dayInput['id'])->where('tour_id', $tour->id)->first();
                if ($day) {
                    $day->update([
                        'day_number' => $dayInput['day_number'],
                        'title' => $dayInput['title'],
                        'body' => $dayInput['body'] ?? null,
                        'body_cn' => $dayInput['body_cn'] ?? null,
                    ]);
                }
            }
            if (!$day) {
                $day = $tour->days()->create([
                    'day_number' => $dayInput['day_number'],
                    'title' => $dayInput['title'],
                    'body' => $dayInput['body'] ?? null,
                    'body_cn' => $dayInput['body_cn'] ?? null,
                ]);
            }
            $processedDayIds[] = $day->id;

            $costsToSync = [];
            if (!empty($dayInput['cost_entries'])) {
                foreach ($dayInput['cost_entries'] as $costEntry) {
                    if (!empty($costEntry['cost_id'])) {
                         $costsToSync[$costEntry['cost_id']] = [
                            'quantity' => $costEntry['quantity'] ?? 1,
                            'notes' => $costEntry['notes'] ?? null
                        ];
                    }
                }
            }
            $day->costs()->sync($costsToSync);
        }
        $daysToDelete = array_diff($currentDayIds, $processedDayIds);
        if (!empty($daysToDelete)) {
            Day::whereIn('id', $daysToDelete)->delete(); // Make sure this cascades or handle pivot detachment
        }
    }

    public function syncDaysForPublicTour(Tour $tour, array $daysData): void
    {
        $tour->days()->each(function ($day) { // More robust deletion that handles relations
            $day->places()->detach();
            $day->hotels()->detach();
            $day->delete();
        });

        foreach ($daysData as $dayInput) {
            $newDay = $tour->days()->create([
                'day_number' => $dayInput['day_number'],
                'title' => $dayInput['title'],
                'body' => $dayInput['body'],
                'body_cn' => $dayInput['body_cn'] ?? null,
            ]);
            if (!empty($dayInput['places'])) {
                $newDay->places()->attach($dayInput['places']);
            }
            if (!empty($dayInput['hotels'])) {
                $newDay->hotels()->attach($dayInput['hotels']);
            }
        }
    }
    
    public function syncPricesForPublicTour(Tour $tour, array $pricesData): void
    {
        $tour->prices()->delete();
        foreach ($pricesData as $priceInput) {
            Price::create([
                'name' => $priceInput['name'],
                'price' => $priceInput['price'],
                'name_cn' => $priceInput['name_cn'] ?? null,
                'price_cn' => $priceInput['price_cn'] ?? null,
                'priceable_id' => $tour->id,
                'priceable_type' => \App\Models\Tour::class
            ]);
        }
    }

    public function updateAttribute(Tour $tour, string $attribute, $value): Tour
    {
        $tour->{$attribute} = $value;
        $tour->save();
        return $tour->fresh();
    }
    
    public function updateMainImage(Tour $tour, UploadedFile $imageFile): Tour
    {
        $newImageName = $this->handleMainImageUpload($tour, $imageFile, $tour->main_image);
        $tour->main_image = $newImageName;
        $tour->save();
        return $tour->fresh();
    }
} 