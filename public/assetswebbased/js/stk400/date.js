function updateTime() {
    const now = new Date();

    // Get date components
    const day = now.getDate();
    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month as two-digit number
    const year = now.getFullYear();

    // Get time components
    const hour = now.getHours().toString().padStart(2, '0');
    const minute = now.getMinutes().toString().padStart(2, '0');
    const second = now.getSeconds().toString().padStart(2, '0');

    // Update HTML elements
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
