function updateTime() {
    const now = new Date();

    // Get date components
    const day = now.getDate();
    const month = now.toLocaleString('en-US', { month: 'long' });
    const year = now.getFullYear();
    
    // Get weekday name
    const weekday = now.toLocaleString('en-US', { weekday: 'long' });

    // Get time components in 24-hour format
    const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    const timeString = now.toLocaleTimeString('en-US', options);
    
    // Split timeString into separate components
    const [hour, minute, second] = timeString.split(':');
    
    // Update HTML elements
    document.getElementById('weekday').textContent = weekday;
    document.getElementById('day').textContent = day;
    document.getElementById('month').textContent = month;
    document.getElementById('year').textContent = year;
    document.getElementById('hour').textContent = hour;
    document.getElementById('minute').textContent = minute;
    document.getElementById('second').textContent = second;
}

// Update time every second
setInterval(updateTime, 1000);

// Initial call to display time immediately
updateTime();
