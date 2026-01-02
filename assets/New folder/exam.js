let timeLeft = EXAM_TIME;
let timerInterval;

/* TIMER */
function startTimer() {
    timerInterval = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        document.getElementById("timer").innerText =
            minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert("Time up! Exam auto-submitted.");
            document.getElementById("examForm").submit();
        }

        timeLeft--;
    }, 1000);
}

/* ATTEMPTED COUNTER */
function countAttempted() {
    let attempted = new Set();
    document.querySelectorAll("input[type=radio]:checked").forEach(r => {
        attempted.add(r.name);
    });
    document.getElementById("attempted").innerText = attempted.size;
}

window.onload = startTimer;
