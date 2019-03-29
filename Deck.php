<?php
    /**
     * Contains methods for interacting with a deck of cards.
     *
     * @author Daniel Sposito <daniel.g.sposito@gmail.com>
     */
class Deck
{

    /**
     * @var array ['value' => 'int/type', 'suit' => 'string']
     */
    public $cards = [];
    public $dealtCards = [];

    public function __construct()
    {
        $this->cards = self::cards();
    }

    /**
     * Builds a deck of cards.
     *
     * @return array
     */
    public static function cards()
    {
        $values = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A');
        $suits = array('S', 'H', 'D', 'C');

        $cards = array();
        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $cards[]= ['value' => $value,'suit' => $suit];
            }
        }

        return $cards;
    }

    public function getNextCard(){
        $card = array_pop($this->cards);
        $this->dealtCards[] = $card;
        return $card;
    }

    public function getRemainingCards(): int
    {
        return count($this->cards);
    }

    public function getDealtCardsCount(): int
    {
        return count($this->dealtCards);
    }

    /**
     * Shuffles an array of cards.
     *
     * @return void
     */
    public function shuffle()
    {
        shuffle($this->cards);
    }
}
