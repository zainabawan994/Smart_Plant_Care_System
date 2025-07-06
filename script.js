document.getElementById('reminderForm').addEventListener('submit', function(event) {
    const plantName = document.getElementById('plantName').value.trim();
    const reminderDate = document.getElementById('reminderDate').value;
    const currentDate = new Date().toISOString().split('T')[0];

    if (!plantName || !reminderDate) {
        event.preventDefault();
        alert('Please fill out all required fields.');
        return;
    }

    if (reminderDate < currentDate) {
        event.preventDefault();
        alert('Please select a future date for the reminder.');
    }
});
