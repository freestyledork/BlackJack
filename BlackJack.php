<?php
include_once 'Deck.php';
include_once 'Console.php';

class BlackJack
{
    /**
     * @var Deck
     */
    private $deck;

    public function startGame(){
        $this->deck = new Deck();
        $this->deck->shuffle();

        $dealerCards = $this->dealHand(2);
        $this->showDealerCard($dealerCards[0]);

        $playerCards = $this->dealHand(2);
        $this->showAllCards($playerCards, 'Player');
        // auto dealer hit
        while ($this->getHandTotal($dealerCards) < 17){
            $dealerCards = $this->hit($dealerCards);
        }
        $stay = false;
        while (!$stay){
            Console::printLine('Would you like to Hit or Stay??');
            $response = Console::readLine();
            if ($response === 'hit'){
                $playerCards = $this->hit($playerCards);
                $this->showAllCards($playerCards, 'Player');
                continue;
            }
            $stay = true;
        }

        $this->showAllCards($dealerCards,'Dealer');
        $this->determineWinner($playerCards,$dealerCards);

//        echo "We Did It!!!";
    }

    private function determineWinner($playerCards,$dealerCards){
        $playerTotal = $this->getHandTotal($playerCards);
        $dealerTotal = $this->getHandTotal($dealerCards);
        if (($playerTotal > $dealerTotal && !$this->isBust($playerCards)) || $this->isBust($dealerCards)){
            if ($playerTotal == 21){
                Console::printLine('Player Won with BLACKJACK!');
                return;
            }
            Console::printLine('Player Won!');
            return;
        }
        if (($playerTotal < $dealerTotal && !$this->isBust($dealerCards)) || $this->isBust($playerCards)){
            if ($dealerTotal == 21){
                Console::printLine('Dealer Won with BLACKJACK!');
                return;
            }
            Console::printLine('Dealer Won!');
            return;
        }
        if ($this->isBust($dealerCards) && $this->isBust($playerCards)){
            Console::printLine('Bust! You both lost!');
            return;
        }
        if ($dealerTotal === $playerTotal){
            Console::printLine('Push');
        }
    }

    private function dealHand($cards){
        for ($i = 0; $i < $cards; $i++){
            $rCards[] =$this->giveCardValue($this->deck->getNextCard());
        }
        return $rCards;
    }

    private function giveCardValue($card){

        if ($card['value'] === 'J' || $card['value'] === 'Q' || $card['value'] === 'K'){
            $card['bjValue'] = 10;
        }elseif ($card['value'] === 'A'){
            $card['bjValue'] = 11;
        }else {
            $card['bjValue'] = $card['value'];
        }
        return $card;
    }

    private function getHandTotal($cards){
        $total = 0;
        foreach ($cards as $card){
            $total += $card['bjValue'];
        }
        return $total;
    }

    private function hit($cards){
        $cards[] = $this->giveCardValue($this->deck->getNextCard());
        return $cards;
    }

    private function showDealerCard($card){
//        $total = $this->getHandTotal($card);
        Console::printLine("Dealer shows: " . $card['value'] . $card['suit']);
    }

    private function showAllCards($cards, $player)
    {
        $cardsStr = '';
        foreach ($cards as $card) {
            $cardsStr .= $card['value'] . $card['suit'] . ' ';
        }
        $total = $this->getHandTotal($cards);
        Console::printLine("{$player} shows({$total}): {$cardsStr}");
    }

    private function isBust($cards){
        return $this->getHandTotal($cards) > 21;
    }
}

(new BlackJack())->startGame();