<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class DeckService
{
    private $deck;
    private $deckId;

    public function __construct()
    {
        $this->resetDeck();
    }

    public function resetDeck()
    {
        $this->deckId = uniqid();
        $this->initializeDeck();
        $this->shuffle();
        Log::info("New deck created and shuffled with ID: " . $this->deckId);
    }

    private function initializeDeck()
    {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        $this->deck = [];
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->deck[] = [
                    'code' => strtolower($value . substr($suit, 0, 1)),
                    'image' => "https://deckofcardsapi.com/static/img/" . strtolower($value . substr($suit, 0, 1)) . ".png",
                    'value' => $value,
                    'suit' => $suit
                ];
            }
        }
        Log::info("Deck initialized with " . count($this->deck) . " cards");
    }

    public function getDeckId()
    {
        return $this->deckId;
    }

    public function shuffle()
    {
        shuffle($this->deck);
        Log::info("Deck shuffled. First card: " . json_encode($this->deck[0]));
    }

    public function drawCards($count)
    {
        $drawnCards = array_splice($this->deck, 0, $count);
        Log::info("Drew " . count($drawnCards) . " cards. First drawn card: " . json_encode($drawnCards[0]));
        return $drawnCards;
    }
}
