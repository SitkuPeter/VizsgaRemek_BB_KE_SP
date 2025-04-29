document.addEventListener("DOMContentLoaded", () => {
    const NEW_SHUFFLE_URL = "http://127.0.0.1:8001/api/deck/new/shuffle/?deck_count=8";
    const PROXY_DRAW_CARDS_URL = "/api/proxy-draw-cards";
    const START_GAME_URL = "/api/blackjack/start";
    const END_GAME_URL = "/api/blackjack/end";

    let deckId = null;
    let playerHand = [];
    let dealerHand = [];
    let gameOver = false;
    let currentBet = 0;

    const apiTokenElement = document.getElementById("api-token");
    const apiToken = apiTokenElement ? apiTokenElement.value : null;

    if (!apiToken) {
        console.error("API token not found. Ensure you are logged in.");
    }

    // DOM Elements
    const dealerCardsDiv = document.getElementById("dealer-cards");
    const playerCardsDiv = document.getElementById("player-cards");
    const dealerScoreP = document.getElementById("dealer-score");
    const playerScoreP = document.getElementById("player-score");
    const gameResultP = document.getElementById("game-result");
    const newGameButton = document.getElementById("new-game-button");
    const hitButton = document.getElementById("hit-button");
    const standButton = document.getElementById("stand-button");
    const userBalance = document.getElementById("user-balance");
    const gameStatus = document.getElementById("game-status");
    const betInput = document.getElementById("bet-input");
    const currentBetID = document.getElementById("current-bet");

    function displayMessage(message, isError = false) {
        if (gameStatus) {
            gameStatus.textContent = message;
            gameStatus.className = isError ? 'error-message' : 'success-message';
        } else {
            console.error('Game status element not found');
        }
    }

    async function fetchNewDeck() {
        try {
            const response = await fetch(NEW_SHUFFLE_URL);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (data.success) {
                deckId = data.deck_id;
            }
            console.log("Deck ID:", deckId);
        } catch (error) {
            console.error("Error fetching new deck:", error);
            displayMessage("Error fetching new deck. Please try again.", true);
        }
    }

    async function drawCards(count) {
        if (!deckId) {
            console.error("Deck ID is null. Ensure a new deck has been fetched.");
            displayMessage("Deck ID is null. Start a new game.", true);
            return [];
        }

        try {
            const response = await fetch(`${PROXY_DRAW_CARDS_URL}?deck_id=${deckId}&count=${count}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            console.log("Drawn cards:", data.cards);
            return data.cards || [];
        } catch (error) {
            console.error("Error drawing cards:", error);
            displayMessage("Error drawing cards. Please try again.", true);
            return [];
        }
    }

    function updateUI(hideDealerCard = true) {
        dealerCardsDiv.innerHTML = "";
        playerCardsDiv.innerHTML = "";

        dealerHand.forEach((card, index) => {
            if (card) {
                const img = document.createElement("img");
                if (index === 1 && hideDealerCard && !gameOver) {
                    img.src = "/storage/img/back.png";

                    img.alt = "Hidden Card";
                } else {
                    img.src = card.image || "/img/back.png";
                    ;
                    img.alt = card.value && card.suit ? `${card.value} of ${card.suit}` : "Unknown Card";
                }
                img.className = "card";
                dealerCardsDiv.appendChild(img);
            }
        });

        playerHand.forEach((card) => {
            if (card) {
                const img = document.createElement("img");
                img.src = card.image || "/img/back.png";
                img.alt = card.value && card.suit ? `${card.value} of ${card.suit}` : "Unknown Card";
                img.className = "card";
                playerCardsDiv.appendChild(img);
            }
        });

        playerScoreP.textContent = `Score: ${calculateScore(playerHand)}`;
        dealerScoreP.textContent = hideDealerCard && !gameOver ? "Score: ?" : `Score: ${calculateScore(dealerHand)}`;
    }

    function calculateScore(hand) {
        let score = 0;
        let acesCount = 0;

        hand.forEach((card) => {
            if (card.value === "ACE") {
                score += 11;
                acesCount++;
            } else if (["KING", "QUEEN", "JACK"].includes(card.value)) {
                score += 10;
            } else {
                score += parseInt(card.value) || 0;
            }
        });

        while (score > 21 && acesCount > 0) {
            score -= 10;
            acesCount--;
        }

        return score;
    }

    async function endGame(resultMessage, result) {
        gameOver = true;
        gameResultP.textContent = resultMessage;
        hitButton.disabled = true;
        standButton.disabled = true;
        newGameButton.disabled = false;
        betInput.hidden=false;
        currentBetID.innerText=`Current Bet: $0`
        
        updateUI(false);

        console.log(`End game called with message: ${resultMessage}, determined result: ${result}`);
        await sendEndGameRequest(result);
    }

    async function startNewGame() {
        currentBet = parseFloat(betInput.value);
        
        if (isNaN(currentBet) || currentBet <= 0) {

            displayMessage("Invalid bet amount", true);
            return;
        }

        try {
            
            const response = await fetch(START_GAME_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': `Bearer ${apiToken}`
                },
                body: JSON.stringify({ bet_amount: currentBet }),
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (data.success) {
                userBalance.textContent = `Balance: ${data.balance}`;
                betInput.hidden=true;
                currentBetID.innerText=`Current Bet: $${betInput.value}`
                gameOver = false;
                gameResultP.textContent = "";
                playerHand = [];
                dealerHand = [];
                newGameButton.disabled = true;
                hitButton.disabled = false;
                standButton.disabled = false;
                await fetchNewDeck();
                playerHand.push(...(await drawCards(2)));
                dealerHand.push(...(await drawCards(2)));
                updateUI();
                const playerScore = calculateScore(playerHand);
                const dealerScore = calculateScore(dealerHand);

                if (playerScore === 21 && dealerScore !== 21) {
                    await endGame("Blackjack! You win!", "win");
                }
            } else {
                displayMessage("Failed to start game. Please try again.", true);
            }
        } catch (error) {
            console.error("Error starting game:", error);
            displayMessage(`Error starting game: ${error.message}. Please try again.`, true);
        }
    }

    async function sendEndGameRequest(result) {
        try {
            const response = await fetch(END_GAME_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': `Bearer ${apiToken}`
                },
                body: JSON.stringify({
                    result: result,
                    bet_amount: currentBet,
                    player_hand: playerHand,
                    dealer_hand: dealerHand
                })
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            if (data.success) {
                userBalance.textContent = `Balance: ${data.balance}`;
                displayMessage("Game ended successfully!");
            } else {
                displayMessage("Failed to record game result. Please contact support.", true);
            }
        } catch (error) {
            console.error("Error ending game:", error);
            displayMessage(`Error ending game: ${error.message}. Please contact support.`, true);
        }
    }

    async function hit() {
        if (gameOver) return;

        const newCards = await drawCards(1);
        if (newCards.length > 0) {
            playerHand.push(newCards[0]);
            updateUI();

            const playerScore = calculateScore(playerHand);
            if (playerScore > 21) {
                await endGame("You busted! Dealer wins.", "lose");
            }
        } else {
            displayMessage("Failed to draw a card. Please try again.", true);
        }
    }

    async function stand() {
        if (gameOver) return;

        hitButton.disabled = true;
        standButton.disabled = true;

        while (calculateScore(dealerHand) < 17) {
            const newCards = await drawCards(1);
            console.log("New dealer card:", newCards[0]);
            if (newCards.length === 0) {
                console.error("Failed to draw a card for the dealer");
                displayMessage("Error drawing dealer card. Please start a new game.", true);
                return;
            }
            dealerHand.push(newCards[0]);
            updateUI(false);
            await new Promise(resolve => setTimeout(resolve, 1000));
        }

        const dealerScore = calculateScore(dealerHand);
        const playerScore = calculateScore(playerHand);

        if (dealerScore > 21) {
            await endGame("Dealer busted! You win!", "win");
        } else if (playerScore > dealerScore) {
            await endGame("You win!", "win");
        } else if (playerScore === dealerScore) {
            await endGame("It's a tie!", "tie");
        } else {
            await endGame("Dealer wins!", "lose");
        }
    }

    newGameButton.addEventListener("click", startNewGame);
    hitButton.addEventListener("click", hit);
    standButton.addEventListener("click", stand);
});
