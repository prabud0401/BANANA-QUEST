class GameEngine {
    constructor() {
        this.score = 0;
        this.timeLeft = 0;
        this.timerId = null;
        this.currentSolution = null;
        this.initialTime = 0;
    }

    initGame(timeLimit) {
        this.timeLeft = timeLimit;
        this.initialTime = timeLimit;
        this.updateTimerDisplay();
        this.startTimer();
    }

    startTimer() {
        this.timerId = setInterval(() => {
            this.timeLeft--;
            this.updateTimerDisplay();
            if (this.timeLeft <= 0) {
                this.gameOver();
            }
        }, 1000);
    }

    updateTimerDisplay() {
        const timerElement = document.getElementById('timer');
        const progressBar = document.getElementById('time-progress');
        if (timerElement && progressBar) {
            timerElement.textContent = this.timeLeft;
            const percentage = (this.timeLeft / this.initialTime) * 100;
            progressBar.style.width = `${percentage}%`;
            
            if (percentage < 20) {
                progressBar.classList.add('bg-red-500');
                progressBar.classList.remove('bg-yellow-500');
            } else {
                progressBar.classList.add('bg-yellow-500');
                progressBar.classList.remove('bg-red-500');
            }
        }
    }

    async handleAnswerSubmission(answer) {
        const isCorrect = answer === this.currentSolution.toString();
        
        if (isCorrect) {
            this.score += 10;
            document.getElementById('score').textContent = this.score;
        }
        
        await this.fetchNewQuestion();
        return isCorrect;
    }

    async fetchNewQuestion() {
        try {
            const response = await fetch('/game');
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            this.currentSolution = doc.getElementById('solution').value;
            document.getElementById('question-img').src = doc.getElementById('question-img').src;
            document.getElementById('answer-input').value = '';
        } catch (error) {
            console.error('Error fetching new question:', error);
        }
    }

    gameOver() {
        clearInterval(this.timerId);
        fetch('/submit-score', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ score: this.score })
        });
        alert(`Game Over! Final Score: ${this.score}`);
        window.location.reload();
    }
}

// Cookie Consent Functions
function checkCookieConsent() {
    if (!document.cookie.includes('cookieConsent=true')) {
        document.getElementById('cookieConsent').classList.remove('hidden');
    }
}

function acceptCookies() {
    document.cookie = "cookieConsent=true; max-age=2592000; path=/";
    document.getElementById('cookieConsent').classList.add('hidden');
}

function declineCookies() {
    document.cookie = "cookieConsent=false; max-age=2592000; path=/";
    document.getElementById('cookieConsent').classList.add('hidden');
}

// Initialize Game
document.addEventListener('DOMContentLoaded', () => {
    checkCookieConsent();
    
    const game = new GameEngine();
    
    // Difficulty selection
    document.querySelectorAll('.difficulty-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            game.difficulty = btn.dataset.difficulty;
            fetch('/set-difficulty', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ difficulty: game.difficulty })
            });
        });
    });

    // Answer submission
    document.getElementById('answer-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const answer = document.getElementById('answer-input').value;
        await game.handleAnswerSubmission(answer);
    });

    // Initialize game timer if on game page
    if (document.getElementById('timer')) {
        const timeLimit = parseInt(document.getElementById('time-limit').value);
        game.initGame(timeLimit);
    }
});