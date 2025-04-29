// Symbols and Payout Table
const symbols = ["🍒", "🍋", "🍉", "⭐", "💎"];
const payoutTable = {
    "🍒": { 3: 5, 4: 10, 5: 20 }, // Reduced payouts
    "🍋": { 3: 10, 4: 20, 5: 40 },
    "🍉": { 3: 15, 4: 30, 5: 60 },
    "⭐": { 3: 20, 4: 40, 5: 80 },
    "💎": { 3: 25, 4: 50, 5: 100 },
};

// DOM Elements
const infoButton = document.getElementById("info-button");
const closeModalButton = document.getElementById("close-modal");
const closeModalBottomButton = document.getElementById("close-modal-bottom");
const infoModal = document.getElementById("info-modal");
const autoSpinButton = document.getElementById("auto-spin");
const spinButton = document.getElementById("spin-reels");
const betAmountInput = document.getElementById("bet-input");
const userBalanceDisplay = document.getElementById("user-balance");
const gameResult = document.getElementById("game-result");
const winHistory = document.getElementById("win-history");
const reels = [
    document.getElementById("reel1"),
    document.getElementById("reel2"),
    document.getElementById("reel3"),
    document.getElementById("reel4"),
    document.getElementById("reel5"),
];

let balance = 0;
let autoSpinActive = false;
let isSpinning = false;

// Modal Functionality
infoButton.addEventListener("click", () => {
    infoModal.classList.remove("hidden");
});
closeModalButton.addEventListener("click", () => {
    infoModal.classList.add("hidden");
});
closeModalBottomButton.addEventListener("click", () => {
    infoModal.classList.add("hidden");
});
infoModal.addEventListener("click", (e) => {
    if (e.target === infoModal) {
        infoModal.classList.add("hidden");
    }
});

// Fetch Balance
document.addEventListener("DOMContentLoaded", fetchBalance);
function fetchBalance() {
    fetch("/api/user/balance", {
        method: "GET",
        headers: {
            Authorization: `Bearer ${document.getElementById("api-token").value}`,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            balance = Number(data.balance); // Convert to number
            updateBalanceUI();
        })
        .catch((error) => console.error("Error fetching balance:", error));
}

// Spinning Animation
function spinAnimation() {
    return new Promise((resolve) => {
        let spinCount = 10;

        const animationInterval = setInterval(() => {
            reels.forEach((reel) => {
                reel.textContent = symbols[Math.floor(Math.random() * symbols.length)];
            });

            if (spinCount-- <= 0) {
                clearInterval(animationInterval);
                resolve(reels.map((reel) => reel.textContent));
            }
        }, 100);
    });
}

// Spin Reels Function
async function spinReels() {
    if (isSpinning) return;

    isSpinning = true;

    const betAmount = parseInt(betAmountInput.value); // Correctly define betAmount here

    if (!validateBet(betAmount)) {
        alert("Invalid Bet Amount!");
        isSpinning = false;
        return;
    }

    disableButtons();
    gameResult.textContent = "Spinning...";
    gameResult.classList.remove("text-green-500", "text-red-500");

    try {
        // Deduct bet
        const startResponse = await fetch("/api/slot-machine/start", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${document.getElementById("api-token").value}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ bet_amount: betAmount }), // Use betAmount here
        });

        if (!startResponse.ok) throw new Error("Bet deduction failed");

        // Perform spinning animation
        const result = await spinAnimation();

        // Calculate winnings
        const winnings = calculateWinnings(result, betAmount);

        // Send end request to server
        const endResponse = await fetch("/api/slot-machine/end", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${document.getElementById("api-token").value}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                result: winnings > 0 ? "win" : "lose",
                bet_amount: betAmount, // Use betAmount here
                reels: result.join(","),
                winnings,
            }),
        });

        const endData = await endResponse.json();

        balance = Number(endData.balance); // Convert to number

        // Update UI based on winnings
        if (winnings > 0) {
            logWin(result, winnings);
            gameResult.textContent = `You won $${winnings}!`;
            gameResult.classList.add("text-green-500");
            gameResult.classList.remove("text-red-500");
        } else {
            gameResult.textContent = "Better luck next time!";
            gameResult.classList.add("text-red-500");
            gameResult.classList.remove("text-green-500");
        }

        updateBalanceUI();
    } catch (error) {
        console.error("Spin error:", error);
        gameResult.textContent = "Error processing spin.";
    } finally {
        isSpinning = false;
        enableButtons();

        // Auto-spin continuation
        if (autoSpinActive && balance >= parseInt(betAmountInput.value)) {
            setTimeout(spinReels, 1000); // Delay between spins
        }
    }
}

// Auto Spin Functionality
function toggleAutoSpin() {
    autoSpinActive = !autoSpinActive;
    autoSpinButton.textContent = autoSpinActive ? "Auto Spin: STOP" : "Auto Spin";

    if (autoSpinActive && !isSpinning) {
        spinReels();
    }
}

// Helper Functions
function validateBet(betAmount) {
    return !isNaN(betAmount) && betAmount > 0 && betAmount <= balance;
}

function calculateWinnings(resultArray, betAmount) {
    let maxWin = 0;

    // Check for non-adjacent matches (3+)
    const symbolCounts = resultArray.reduce((acc, symbol) => {
        acc[symbol] = (acc[symbol] || 0) + 1;
        return acc;
    }, {});

    Object.entries(symbolCounts).forEach(([symbol, count]) => {
        if (count >= 3 && payoutTable[symbol][count]) {
            maxWin += payoutTable[symbol][count] * betAmount; // Add payout for non-adjacent matches
        }
    });

    return maxWin; // Return reduced winnings for house advantage.
}

function logWin(resultArray, winnings) {
    const winEntry = document.createElement("li");

	// Style the win entry in the history list
	winEntry.className =
	  "py-2 px-4 bg-green-100 dark:bg-green-900 rounded mb-2 text-black dark:text-white";

	winEntry.textContent =
	  `${resultArray.join(",")} - Won $${winnings}`;
      
	winHistory.prepend(winEntry);
}

function updateBalanceUI() { 
	userBalanceDisplay.textContent=`Balance: $${Number(balance).toFixed(2)}`;
}

function disableButtons() { 
	spinButton.disabled=true; 
	autoSpinButton.disabled=true; 
}

function enableButtons() { 
	spinButton.disabled=false; 
	autoSpinButton.disabled=false; 
}

// Event Listeners
spinButton.addEventListener('click', spinReels);
autoSpinButton.addEventListener('click', toggleAutoSpin);
