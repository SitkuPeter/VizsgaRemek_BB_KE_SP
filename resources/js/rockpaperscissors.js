document.addEventListener("DOMContentLoaded", function () {
    let playerScore = 0;
    let computerScore = 0;
    let lastBetAmount = 0;

    const choices = document.querySelectorAll(".choice");
    const resultDisplay = document.getElementById("result");
    const playerScoreDisplay = document.getElementById("player-score");
    const computerScoreDisplay = document.getElementById("computer-score");
    const playerChoiceDisplay = document.getElementById("player-choice");
    const computerChoiceDisplay = document.getElementById("computer-choice");

    const choiceIcons = {
        rock: "✊",
        paper: "✋",
        scissors: "✌️",
    };

    function getComputerChoice(playerChoice) {
        const options = ["rock", "paper", "scissors"];
        const filteredOptions = options.filter(choice => choice !== playerChoice); // Remove player's choice
        return filteredOptions[Math.floor(Math.random() * filteredOptions.length)];
    }

    function determineWinner(playerChoice, computerChoice) {
        if (playerChoice === computerChoice) {
            return "It's a tie!";
        }
        if (
            (playerChoice === "rock" && computerChoice === "scissors") ||
            (playerChoice === "paper" && computerChoice === "rock") ||
            (playerChoice === "scissors" && computerChoice === "paper")
        ) {
            playerScore++;
            playerScoreDisplay.textContent = playerScore;
            return "You win! 🎉";
        } else {
            computerScore++;
            computerScoreDisplay.textContent = computerScore;
            return "You lose! 😞";
        }
    }

    function animateComputerChoice(finalChoice, callback) {
        const options = ["rock", "paper", "scissors"];
        let index = 0;
        let interval = setInterval(() => {
            computerChoiceDisplay.textContent = choiceIcons[options[index]];
            index = (index + 1) % options.length;
        }, 150);

        setTimeout(() => {
            clearInterval(interval);
            computerChoiceDisplay.textContent = choiceIcons[finalChoice];
            callback();
        }, 1200);
    }

    function playGame(playerChoice) {
        const betAmount = parseFloat(document.getElementById('bet-input').value);

        // Validate bet amount
        if (isNaN(betAmount) || betAmount <= 0) {
            alert("Please enter a valid bet amount.");
            choices.forEach(button => button.disabled = false);
            return;
        }

        const computerChoice = getComputerChoice(playerChoice); // Exclude player's choice

        playerChoiceDisplay.textContent = choiceIcons[playerChoice];
        resultDisplay.textContent = "Computer is choosing... 🤖";

        choices.forEach(button => button.disabled = true);

        animateComputerChoice(computerChoice, () => {
            const result = determineWinner(playerChoice, computerChoice);
            resultDisplay.textContent = `You chose ${playerChoice.toUpperCase()}, Computer chose ${computerChoice.toUpperCase()}. ${result}`;

            // Send request to start the game
            fetch('/api/rock-paper-scissors/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + document.getElementById('api-token').value
                },
                body: JSON.stringify({
                    bet_amount: betAmount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    choices.forEach(button => button.disabled = false);
                    return;
                }
                console.log(data);

                // Send request to end the game
                fetch('/api/rock-paper-scissors/end', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + document.getElementById('api-token').value
                    },
                    body: JSON.stringify({
                        result: result.includes('win') ? 'win' : result.includes('tie') ? 'tie' : 'lose',
                        bet_amount: betAmount,
                        player_choice: playerChoice,
                        computer_choice: computerChoice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Update balance display
                    document.getElementById('user-balance').textContent = 'Current Balance: $' + data.balance;
                    // Update current bet display
                    document.getElementById('current-bet').textContent = 'Current Bet: $' + betAmount;
                    lastBetAmount = betAmount;
                })
                .catch(error => console.error('Error:', error));
            })
            .catch(error => console.error('Error:', error));

            setTimeout(() => choices.forEach(button => button.disabled = false), 500);
        });
    }

    choices.forEach(button => {
        button.addEventListener("click", function () {
            const playerChoice = this.getAttribute("data-choice");
            playGame(playerChoice);
        });
    });

   
});
