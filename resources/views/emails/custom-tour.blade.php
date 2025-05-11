<!DOCTYPE html>
<html>
<head>
    <title>New Custom Tour Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2d3748;">New Custom Tour Request</h2>
        
        <div style="margin-top: 20px;">
            <p><strong>From:</strong> {{ $email }}</p>
            <p><strong>Country:</strong> {{ $country }}</p>
            
            <div style="margin-top: 20px;">
                <h3 style="color: #4a5568;">Travel Requirements:</h3>
                <p style="background: #f7fafc; padding: 15px; border-radius: 5px;">{{ $note }}</p>
            </div>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
            <p style="color: #718096; font-size: 0.875rem;">
                This email was sent from your travel agency website's contact form.
            </p>
        </div>
    </div>
</body>
</html> 