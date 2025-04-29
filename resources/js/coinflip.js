document.addEventListener("DOMContentLoaded", function () {
    const headsBtn = document.getElementById("heads-btn");
    const tailsBtn = document.getElementById("tails-btn");
    const coinContainer = document.getElementById("coin-container");
    const coin = document.getElementById("coin");
    const resultDiv = document.getElementById("result");
    const resetBtn = document.getElementById("reset-btn");
    const userBalanceElement = document.getElementById("user-balance");
    const betInput = document.getElementById("bet-input");
    const currentBetID = document.getElementById("current-bet");

    const START_GAME_URL = "/api/coinflip/start";
    const END_GAME_URL = "/api/coinflip/end";

    let currentBet = 0;

    function flipCoin() {
        return Math.random() < 0.5 ? "heads" : "tails";
    }

    async function startGame(betAmount) {
        try {
            const response = await fetch(START_GAME_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': `Bearer ${document.getElementById('api-token').value}`
                },
                body: JSON.stringify({ bet_amount: betAmount })
            });
            const data = await response.json();
            if (data.success) {
                userBalanceElement.textContent = `Balance: $${data.balance}`;
                currentBetID.innerText=`Current Bet: $${betInput.value}`
                return true;
            } else {
                alert(data.message);
                return false;
            }
        } catch (error) {
            console.error("Error starting game:", error);
            alert("Error starting game. Please try again.");
            return false;
        }
    }

    async function endGame(result, userChoice, coinResult) {
        try {
            const response = await fetch(END_GAME_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': `Bearer ${document.getElementById('api-token').value}`
                },
                body: JSON.stringify({
                    result: result,
                    bet_amount: currentBet,
                    user_choice: userChoice,
                    coin_result: coinResult
                })
            });
            const data = await response.json();
            if (data.success) {
                userBalanceElement.textContent = `Balance: $${data.balance}`;
                currentBetID.innerText=`Current Bet: $0`
            } else {
                alert("Failed to record game result. Please contact support.");
            }
        } catch (error) {
            console.error("Error ending game:", error);
            alert("Error ending game. Please contact support.");
        }
    }

    async function showResult(userChoice) {
        headsBtn.disabled = true;
        tailsBtn.disabled = true;

        currentBet = betInput.value
        if (isNaN(currentBet) || currentBet <= 0) {
            alert("Invalid bet amount");
            headsBtn.disabled = false;
            tailsBtn.disabled = false;
            return;
        }

        const gameStarted = await startGame(currentBet);
        if (!gameStarted) {
            headsBtn.disabled = false;
            tailsBtn.disabled = false;
            return;
        }

        const coinResult = flipCoin();

        coin.style.animation = "none";
        coin.style.transform = "";

        coinContainer.classList.remove("hidden");
        setTimeout(() => {
            coin.style.animation = "flip 2s ease-in-out";
        }, 10);

        setTimeout(async () => {
            coin.style.animation = "none";
            coin.style.transform =
                coinResult === "heads" ? "rotateY(0deg)" : "rotateY(180deg)";

            let message = `You chose ${userChoice}. The coin landed on ${coinResult}! `;
            const result = userChoice === coinResult ? "win" : "lose";
            message += result === "win" ? "You Win!" : "You Lose!";

            resultDiv.textContent = message;
            resultDiv.classList.remove("hidden");
            resetBtn.classList.remove("hidden");

            await endGame(result, userChoice, coinResult);
        }, 2000);
    }

    headsBtn.addEventListener("click", () => showResult("heads"));
    tailsBtn.addEventListener("click", () => showResult("tails"));

    resetBtn.addEventListener("click", function () {
        coinContainer.classList.add("hidden");
        resultDiv.classList.add("hidden");
        resetBtn.classList.add("hidden");
        headsBtn.disabled = false;
        tailsBtn.disabled = false;
        coin.style.transform = "";
    });
    
});
