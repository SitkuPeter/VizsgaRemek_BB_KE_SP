document.addEventListener("DOMContentLoaded", () => {
    const rouletteNumbers = [
        { number: 0, color: "green" }, { number: 32, color: "red" }, { number: 15, color: "black" },
        { number: 19, color: "red" }, { number: 4, color: "black" }, { number: 21, color: "red" },
        { number: 2, color: "black" }, { number: 25, color: "red" }, { number: 17, color: "black" },
        { number: 34, color: "red" }, { number: 6, color: "black" }, { number: 27, color: "red" },
        { number: 13, color: "black" }, { number: 36, color: "red" }, { number: 11, color: "black" },
        { number: 30, color: "red" }, { number: 8, color: "black" }, { number: 23, color: "red" },
        { number: 10, color: "black" }, { number: 5, color: "red" }, { number: 24, color: "black" },
        { number: 16, color: "red" }, { number: 33, color: "black" }, { number: 1, color: "red" },
        { number: 20, color: "black" }, { number: 14, color: "red" }, { number: 31, color: "black" },
        { number: 9, color: "red" }, { number: 22, color: "black" }, { number: 18, color: "red" },
        { number: 29, color: "black" }, { number: 7, color: "red" }, { number: 28, color: "black" },
        { number: 12, color: "red" }, { number: 35, color: "black" }, { number: 3, color: "red" },
        { number: 26, color: "black" }
    ];

    let isSpinning = false;
    let previousWinners = [];
    const rouletteWheel = document.getElementById("roulette-container");
    const spinButton = document.getElementById("spin-button");
    const resultDisplay = document.getElementById("result");
    const previousWinnersContainer = document.getElementById("previous-winners-container");
    const betAmountInput = document.getElementById("bet-input");
    const betTypeSelect = document.getElementById("bet-type");
    


    // Betting options
    const betTypes = [
        { value: 'even', text: 'Even' },
        { value: 'odd', text: 'Odd' },
        { value: 'red', text: 'Red' },
        { value: 'black', text: 'Black' },
        { value: 'green', text: 'Green (0)' },
    ];

    // Populate bet type select
    betTypes.forEach(betType => {
        const option = document.createElement('option');
        option.value = betType.value;
        option.textContent = betType.text;
        betTypeSelect.appendChild(option);
    });

    spinButton.addEventListener("click", () => {
        if (isSpinning) return;
        isSpinning = true;

        const betAmount = parseInt(betAmountInput.value);
        const betType = betTypeSelect.value;

        if (!betAmount || betAmount < 1) {
            alert("Please enter a valid bet amount.");
            isSpinning = false;
            return;
        }

        // Send request to start the game
        fetch('/api/roulette/start', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + document.getElementById('api-token').value
            },
            body: JSON.stringify({
                bet_amount: betAmount,
                
                bet_type: betType
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById("current-bet").textContent = 'Current Bet: $'+betAmountInput.value;
        })
        .catch(error => console.error('Error:', error));

        // Faster initial delay and fewer iterations
        let delay = 50; // Reduced initial delay for faster start
        let currentIndex = Math.floor(Math.random() * rouletteNumbers.length);
        let iterations = 0;
        let maxIterations = 30; // Reduced total iterations for a quicker spin

        const spinStep = () => {
            const currentElement = rouletteNumbers[currentIndex];
            updateRouletteDisplay(currentElement);

            if (iterations >= maxIterations) {
                showResult(currentElement);
                isSpinning = false;
                return;
            }

            iterations++;
            delay = Math.min(delay + 30, 500); // Aggressive slowdown for a faster end
            currentIndex = (currentIndex + 1) % rouletteNumbers.length;
            setTimeout(spinStep, delay);
        };

        spinStep();
    });

    const updateRouletteDisplay = (element) => {
        rouletteWheel.textContent = element.number;
        rouletteWheel.style.backgroundColor = element.color;
    };

    const showResult = (winner) => {
        const isEven = winner.number !== 0 && winner.number % 2 === 0 ? "Even" : "Odd";

        // Update result display with styled content
        resultDisplay.innerHTML = `
            <div class="text-2xl font-bold">${winner.number}</div>
            <div class="text-lg capitalize">Color: <span style="color:${winner.color};">${winner.color}</span></div>
            <div class="text-lg">Type: ${isEven}</div>
        `;

        // Add animation to the result display
        resultDisplay.style.animation = "fadeIn 0.5s ease";

        // Update previous winners list
        previousWinners.push(winner);
        if (previousWinners.length > 10) previousWinners.shift();

        previousWinnersContainer.innerHTML = previousWinners.map((w) =>
            `<div class="w-12 h-12 flex items-center justify-center text-white font-bold rounded-full shadow-md" 
                 style="background-color: ${w.color};">
                ${w.number}
            </div>`
        ).join('');

        // Determine if the bet was a win
        const betType = betTypeSelect.value;
        let winnings = 0;
        if ((betType === 'even' && winner.number !== 0 && winner.number % 2 === 0) ||
            (betType === 'odd' && winner.number !== 0 && winner.number % 2 !== 0) ||
            (betType === 'red' && winner.color === 'red') ||
            (betType === 'black' && winner.color === 'black') ||
            (betType === 'green' && winner.color === 'green')) {
            winnings = parseInt(betAmountInput.value) * 2; // Simple payout for demonstration
        }

        // Send request to end the game
        fetch('/api/roulette/end', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + document.getElementById('api-token').value
            },
            body: JSON.stringify({
                result: winnings > 0 ? 'win' : 'lose',
                bet_amount: parseInt(betAmountInput.value),
                bet_type: betTypeSelect.value,
                winnings: winnings
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Update balance display
            document.getElementById('user-balance').textContent = 'Balance: $' + data.balance;
            
        })
        .catch(error => console.error('Error:', error));
        
    };
    
});

