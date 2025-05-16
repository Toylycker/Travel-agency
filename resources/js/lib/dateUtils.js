/**
 * Formats a timestamp into YYYY-MM-DD format
 * @param {string|Date} timestamp - The timestamp to format
 * @returns {string|null} - Formatted date string or null if timestamp is falsy
 */
export function formatDate(timestamp) {
    if (!timestamp) return null;
    const date = new Date(timestamp);
    return date.toISOString().slice(0, 10); // Or any format you prefer
} 