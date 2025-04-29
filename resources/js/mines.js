document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const minesGrid = document.getElementById("mines-grid");
    const startGameButton = document.getElementById("start-game");
    const cashOutButton = document.getElementById("cash-out");
    const betInput = document.getElementById("bet-input");
    const currentBet = document.getElementById("current-bet");
    const gameResult = document.getElementById("game-result");
    const userBalance = document.getElementById("user-balance");
    const currentMultiplier = document.getElementById("current-multiplier");
    const multiplierProgress = document.getElementById("multiplier-progress");
    const gameHistory = document.getElementById("game-history");
    const infoButton = document.getElementById("info-button");
    const infoModal = document.getElementById("info-modal");
    const closeInfoButton = document.getElementById("close-info");

    // API Token
    const apiToken = document.getElementById("api-token")?.value;

    // Game State
    let gameActive = false;
    let minesCount = 7; 
    let betAmount = 0;
    let revealedCount = 0;
    let grid = [];
    let multiplier = 1.0;
    let maxMultiplier = 0;

    // Constants
    const GRID_SIZE = 25; // 5x5 grid

    // Initialize the game
    function initGame() {
        createGrid();
        setupEventListeners();
    }

    // Create the grid
    function createGrid() {
        minesGrid.innerHTML = "";
        for (let i = 0; i < GRID_SIZE; i++) {
            const tile = document.createElement("div");
            tile.className = "mine-tile";
            tile.dataset.index = i;

            const content = document.createElement("div");
            content.className = "tile-content";
            tile.appendChild(content);

            minesGrid.appendChild(tile);
        }
    }

    // Setup event listeners
    function setupEventListeners() {
        // Start game button
        startGameButton.addEventListener("click", startGame);

        // Cash out button
        cashOutButton.addEventListener("click", cashOut);

        // Grid tiles
        minesGrid.addEventListener("click", handleTileClick);

        // Info modal
        infoButton.addEventListener("click", () =>
            infoModal.classList.remove("hidden")
        );
        closeInfoButton.addEventListener("click", () =>
            infoModal.classList.add("hidden")
        );
    }

    // Start a new game
    async function startGame() {
        betAmount = parseFloat(betInput.value);

        if (isNaN(betAmount) || betAmount <= 0) {
            gameResult.textContent = "Please enter a valid bet amount";
            gameResult.className =
                "text-lg font-bold text-center mt-4 text-red-500";
            return;
        }

        try {
            const response = await fetch("/api/mines/start", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${apiToken}`,
                },
                body: JSON.stringify({ bet_amount: betAmount }),
            });

            const data = await response.json();

            if (!data.success) {
                gameResult.textContent = data.message || "Failed to start game";
                gameResult.className =
                    "text-lg font-bold text-center mt-4 text-red-500";
                return;
            }

            // Update UI
            userBalance.textContent = `Current Balance: $${data.balance.toFixed(
                2
            )}`;
            currentBet.textContent = `Current Bet: $${betAmount.toFixed(2)}`;

            // Reset game state
            gameActive = true;
            revealedCount = 0;
            multiplier = 1.0;
            updateMultiplier();

            // Clean up any styles from previous games
            cleanupStyles();

            // Reset the grid UI completely
            resetGridUI();

            // Generate new grid data
            generateGrid();

            // Update UI
            startGameButton.disabled = true;
            cashOutButton.disabled = false;
            betInput.disabled = true;
            gameResult.textContent =
                "Game started! Click on tiles to reveal them.";
            gameResult.className = "text-lg font-bold text-center mt-4";

            // Start multiplier animation
            multiplierProgress.classList.add("active");
        } catch (error) {
            console.error("Error starting game:", error);
            gameResult.textContent = "Error starting game. Please try again.";
            gameResult.className =
                "text-lg font-bold text-center mt-4 text-red-500";
        }
    }

    // Reset the grid UI completely
    function resetGridUI() {
        console.log("Resetting grid UI");
        // Clear all existing tiles
        minesGrid.innerHTML = "";

        // Recreate all tiles from scratch
        for (let i = 0; i < GRID_SIZE; i++) {
            const tile = document.createElement("div");
            tile.className = "mine-tile";
            tile.dataset.index = i;

            const content = document.createElement("div");
            content.className = "tile-content";
            tile.appendChild(content);

            minesGrid.appendChild(tile);
        }
    }

    // Generate the grid with mines and gems
    function generateGrid() {
        grid = Array(GRID_SIZE).fill("gem");

        // Place mines randomly
        let minesPlaced = 0;
        while (minesPlaced < minesCount) {
            const randomIndex = Math.floor(Math.random() * GRID_SIZE);
            if (grid[randomIndex] !== "mine") {
                grid[randomIndex] = "mine";
                minesPlaced++;
            }
        }

        // Calculate max possible multiplier based on mines count
        const safeSquares = GRID_SIZE - minesCount;
        maxMultiplier = calculateMaxMultiplier(minesCount, safeSquares);
    }

    // Calculate the maximum possible multiplier based on mines count
    function calculateMaxMultiplier(_, safeSquares) {
        const baseMultiplier = 1.5; // Fixed base multiplier for 10 mines

        // Use a lower growth factor to reduce the exponential increase
        const growthFactor = 1.12;

        // Calculate max multiplier with reduced exponential growth
        return baseMultiplier * Math.pow(growthFactor, safeSquares - 1);
    }

    // Handle tile click
    function handleTileClick(event) {
        if (!gameActive) return;

        const tile = event.target.closest(".mine-tile");
        if (!tile || tile.classList.contains("revealed")) return;

        const index = parseInt(tile.dataset.index);
        const tileContent = tile.querySelector(".tile-content");

        // Reveal the tile
        tile.classList.add("revealed");

        if (grid[index] === "mine") {
            // Hit a mine
            tile.classList.add("mine");
            tileContent.textContent = "💣";
            endGame("lose");
        } else {
            // Found a gem
            tile.classList.add("gem");
            tileContent.textContent = "💎";
            revealedCount++;

            // Update multiplier
            updateMultiplierOnReveal();

            // Check if all safe tiles are revealed
            if (revealedCount === GRID_SIZE - minesCount) {
                endGame("win");
            }
        }
    }

    // Update multiplier when a safe tile is revealed
    function updateMultiplierOnReveal() {
        
        const totalSafeSquares = GRID_SIZE - minesCount;
        const progressRatio = revealedCount / totalSafeSquares;

       
        const progressFactor = Math.pow(progressRatio, 1.5);

        
        multiplier = 1 + (maxMultiplier - 1) * progressFactor;

        
        updateMultiplier();
    }

    // Update multiplier display
    function updateMultiplier() {
        currentMultiplier.textContent = `Multiplier: ${multiplier.toFixed(2)}x`;
        const progressPercentage =
            ((multiplier - 1) / (maxMultiplier - 1)) * 100;
        multiplierProgress.style.width = `${Math.min(
            progressPercentage,
            100
        )}%`;
    }

    // Cash out and end the game with current winnings
    async function cashOut() {
        if (!gameActive) return;

        // Disable game interaction during cashout
        gameActive = false;
        cashOutButton.disabled = true;

        const winnings = betAmount * multiplier;
        // Show a message that we're revealing mines
        gameResult.textContent = "Cashing out and revealing mines...";
        gameResult.className =
            "text-lg font-bold text-center mt-4 text-blue-500";

        console.log("Cashing out with winnings:", winnings);
        console.log("Current grid state:", grid);

        // Reveal all mines with a slight delay for better UX
        setTimeout(() => {
            // Make sure all mines are revealed
            revealAllMines(true); // Pass true to indicate this is a cash-out reveal

            // Add a longer delay before ending the game to allow animations to be seen
            setTimeout(() => {
                // Double-check that all mines are revealed
                grid.forEach((type, index) => {
                    if (type === "mine") {
                        const tile = document.querySelector(
                            `.mine-tile[data-index="${index}"]`
                        );
                        if (tile) {
                            const tileContent =
                                tile.querySelector(".tile-content");
                            if (tileContent && !tileContent.textContent) {
                                console.log(
                                    `Fixing unrevealed mine at index ${index}`
                                );
                                tile.style.backgroundColor = "#f59e0b"; // Amber-500
                                tile.classList.add(
                                    "revealed",
                                    "mine",
                                    "mine-revealed"
                                );
                                tileContent.style.opacity = "1";
                                tileContent.textContent = "💣"; // Bomb emoji
                            }
                        }
                    }
                });

                endGame("win", winnings);
            }, 1500);
        }, 500);
    }

    // End the game
    async function endGame(result, winnings = 0) {
        gameActive = false;

        // Stop multiplier animation
        multiplierProgress.classList.remove("active");

        // Update UI
        startGameButton.disabled = false;
        cashOutButton.disabled = true;
        betInput.disabled = false;

        // Reveal all mines if player lost (already revealed for cash-out)
        if (result === "lose") {
            revealAllMines(false); // false indicates this is a loss reveal
            gameResult.textContent = "You hit a mine! Game over.";
            gameResult.className =
                "text-lg font-bold text-center mt-4 text-red-500";
            winnings = 0;
        } else {
            gameResult.textContent = `You won $${winnings.toFixed(2)}!`;
            gameResult.className =
                "text-lg font-bold text-center mt-4 text-green-500";
        }

        // Reset grid data to prepare for next game
        grid = [];

        try {
            const response = await fetch("/api/mines/end", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${apiToken}`,
                },
                body: JSON.stringify({
                    result: result,
                    bet_amount: betAmount,
                    mines_count: minesCount,
                    revealed_cells: revealedCount,
                    winnings: winnings,
                }),
            });

            const data = await response.json();

            if (data.success) {
                userBalance.textContent = `Current Balance: $${data.balance.toFixed(
                    2
                )}`;

                // Add to game history
                addToGameHistory(
                    result,
                    betAmount,
                    winnings,
                    minesCount,
                    revealedCount
                );
            }
        } catch (error) {
            console.error("Error ending game:", error);
        }
    }

    // Reveal all mines
    function revealAllMines(isCashOut = false) {
        console.log("Revealing all mines, isCashOut:", isCashOut);
        console.log("Grid state:", grid);

        // Debug: Count mines in grid
        const mineCount = grid.filter((cell) => cell === "mine").length;
        console.log(`Total mines in grid: ${mineCount}`);

        grid.forEach((type, index) => {
            if (type === "mine") {
                console.log(
                    `Found mine at index ${index}, attempting to reveal`
                );

                // Use a more specific selector to ensure we get the right element
                const tile = document.querySelector(
                    `.mine-tile[data-index="${index}"]`
                );

                if (tile) {
                    console.log(`Found tile element for index ${index}`);

                    // Add mine class to ensure proper styling
                    tile.classList.add(
                        "revealed",
                        "pointer-events-none",
                        "mine"
                    );

                    // Different styling for cash-out vs loss
                    if (isCashOut) {
                        // For cash-out, show mines with a yellow/amber color
                        console.log(
                            `Applying cashout styling to mine at index ${index}`
                        );
                        tile.style.backgroundColor = "#f59e0b"; // Amber-500
                        tile.classList.add("mine-revealed");
                    } else {
                        // For loss, show mines with red color
                        console.log(
                            `Applying loss styling to mine at index ${index}`
                        );
                        tile.style.backgroundColor = "#dc2626"; // Red-600
                        tile.classList.add("mine-revealed");
                    }

                    // Get and update the tile content
                    const tileContent = tile.querySelector(".tile-content");
                    if (tileContent) {
                        tileContent.style.opacity = "1";
                        tileContent.classList.add("animate-scale-in");
                        tileContent.textContent = "💣"; // Bomb emoji
                        console.log(
                            `Updated tile content for mine at index ${index}`
                        );
                    } else {
                        console.error(
                            `Could not find tile content for mine at index ${index}`
                        );
                    }
                } else {
                    console.error(
                        `Could not find tile element for mine at index ${index}`
                    );
                }
            }
        });
    }

    // Clean up any inline styles that might persist between games
    function cleanupStyles() {
        document.querySelectorAll(".mine-tile").forEach((tile) => {
            // Remove any inline styles
            tile.removeAttribute("style");

            // Remove any classes that might affect the next game
            tile.classList.remove(
                "revealed",
                "mine",
                "gem",
                "mine-revealed",
                "pointer-events-none"
            );

            // Reset the tile content
            const content = tile.querySelector(".tile-content");
            if (content) {
                content.removeAttribute("style");
                content.classList.remove("opacity-100", "animate-scale-in");
                content.textContent = "";
            }
        });
    }

    // Add game to history
    function addToGameHistory(result, bet, winnings, mines, revealed) {
        const historyItem = document.createElement("li");
        historyItem.className =
            (result === "win" ? "text-green-500" : "text-red-500") +
            " py-1 border-b border-gray-200 dark:border-gray-700 last:border-0";

        const timestamp = new Date().toLocaleTimeString();
        historyItem.textContent = `${timestamp} - ${
            result === "win" ? "Won" : "Lost"
        } $${
            result === "win" ? winnings.toFixed(2) : bet.toFixed(2)
        } with ${mines} mines (${revealed} revealed)`;

        gameHistory.prepend(historyItem);

        // Limit history items
        if (gameHistory.children.length > 10) {
            gameHistory.removeChild(gameHistory.lastChild);
        }
    }

    // Initialize the game
    initGame();
});
