// Select DOM Elements
const betInput = document.getElementById('bet-input');
const startButton = document.getElementById('start-game');
const cashOutButton = document.getElementById('cash-out');
const multiplierDisplay = document.getElementById('current-multiplier');
const progressFill = document.getElementById('progress-fill');
const crashHistory = document.getElementById('crash-history');
const gameResult = document.getElementById('game-result');

let crashPoint = 0;
let currentMultiplier = 1.00;
let intervalId = null;
let hasCashedOut = false;
let currentBetAmount = 0;
let isGameActive = false; // Prevent concurrent games
let currentGameId = null; // Unique game ID

// Start Game
startButton.addEventListener('click', () => {
    currentBetAmount = parseFloat(betInput.value);

    if (isNaN(currentBetAmount) || currentBetAmount <= 0) {
        alert('Please enter a valid bet amount.');
        return;
    }

    if (isGameActive) {
        alert('A game is already in progress. Please wait for it to finish.');
        return;
    }

    // Start game API call
    fetch('/api/crash/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + document.getElementById('api-token').value
        },
        body: JSON.stringify({
            bet_amount: currentBetAmount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            return;
        }
        document.getElementById("current-bet").textContent = 'Current Bet: $' + currentBetAmount.toFixed(2);
        startGameLogic();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to start game. Please try again.');
    });
});

function startGameLogic() {
    isGameActive = true;
    startButton.disabled = true;
    resetGame();

    // Generate unique game ID
    currentGameId = Date.now().toString(36) + Math.random().toString(36).substr(2, 5);

    crashPoint = getRandomCrashPoint();
    console.log(`Crash Point: ${crashPoint.toFixed(2)}x`);
    
    cashOutButton.disabled = false;

    intervalId = setInterval(() => {
        currentMultiplier += 0.01; // Slower multiplier growth (was 0.02)
        multiplierDisplay.textContent = `${currentMultiplier.toFixed(2)}x`;
        progressFill.style.width = `${(currentMultiplier / 10) * 100}%`;

        if (currentMultiplier >= crashPoint) {
            endGame('lose', currentBetAmount);
        }
    }, 200); // Slower update interval (was 100ms)
}

// Cash Out
cashOutButton.addEventListener('click', () => {
    if (!hasCashedOut && isGameActive) {
        hasCashedOut = true;
        clearInterval(intervalId);
        cashOutButton.disabled = true;

        const winnings = (currentBetAmount * currentMultiplier).toFixed(2);
        endGame('win', currentBetAmount, winnings);
    }
});

// End Game Handler
function endGame(result, betAmount, winnings = 0) {
    if (!isGameActive) return;

    const gameData = {
        result: result,
        bet_amount: betAmount,
        cashout_multiplier: result === 'win' ? currentMultiplier : null,
        crash_point: crashPoint,
        winnings: winnings,
        game_id: currentGameId
    };

    // API call to end game
    fetch('/api/crash/end', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + document.getElementById('api-token').value
        },
        body: JSON.stringify(gameData)
    }).finally(() => {
        isGameActive = false;
        startButton.disabled = false;
    });

    clearInterval(intervalId);
    intervalId = null;

    // Update UI based on result
    if (result === 'win') {
        gameResult.textContent = `You cashed out at ${currentMultiplier.toFixed(2)}x! Winnings: $${winnings}`;
        gameResult.classList.add('text-green-500');
        gameResult.classList.remove('text-red-500');
        addCrashToHistory(currentMultiplier.toFixed(2));
    } else {
        gameResult.textContent = `Crashed at ${crashPoint.toFixed(2)}x! You lost $${betAmount}`;
        gameResult.classList.add('text-red-500');
        gameResult.classList.remove('text-green-500');
        addCrashToHistory(crashPoint.toFixed(2));
    }
}

// Reset Game
function resetGame() {
    clearInterval(intervalId);
    currentMultiplier = 1.00;
    multiplierDisplay.textContent = '1.00x';
    progressFill.style.width = '0%';
    gameResult.textContent = '';
    gameResult.classList.remove('text-red-500', 'text-green-500');
    hasCashedOut = false;
    cashOutButton.disabled = true;
}

// Add Crash History
function addCrashToHistory(point) {
    const listItem = document.createElement('li');
    listItem.className = 'py-1 px-3 bg-neutral-100 dark:bg-neutral-700 rounded-md mb-1';
    listItem.textContent = `Crashed at ${point}x`;
    crashHistory.prepend(listItem);
}

// Crash Point Generation (Probability: P(crash ≥ x) = 1/x)
function getRandomCrashPoint() {
    let r = Math.random();
    return Math.max(1.00, (1 / (1 - r)));
}

/* Probability Distribution:
- 50% chance to crash between 1.00x and 2.00x
- 10% chance to reach at least 10.00x
- 1% chance to reach at least 100.00x */
