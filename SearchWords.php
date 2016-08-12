<?php

class SearchWords {

    protected $text = '';
    protected $list = [];
    protected $repeatedWords = [];
    protected $wordsToSearch;

    public function __construct($text, $total = 5) {
        $this->text = $text;
        $this->wordsToSearch = $total;
    }

    private function ignoreWords()
    {
        return [
            'an',
            'a', 
            'in',
            'at',
            'the',
            'so',
            'his',
            'he',
            'she',
            'for',
            'on',
            'yet',
            'her',
            'me',
            'do',
            'am',
            'it',
            'no',
            'to',
            'if',
            'of'
        ];
    }

    protected function splitText()
    {
        // remove unnecessary chars
        $removeParagraph = str_replace(PHP_EOL . PHP_EOL, ' ', $this->text);
        $removeDoubleSpaces = str_replace('  ', ' ', $removeParagraph);

        // Split and remove dots and commas 
        $this->list = explode(' ', $removeDoubleSpaces);
        array_walk($this->list, function(&$item) {
            $item = strtolower(str_replace(['.', ','], '', $item));
        });
    }

    protected function removeIgnoreWords()
    {
        foreach($this->list as $index => $word) {
            if (in_array($word, $this->ignoreWords())) {
                unset($this->list[$index]);
            }
        }
    }

    protected function setRepeatedWords()
    {
        $counted = array_count_values($this->list);
        array_multisort($counted, SORT_DESC);
        $mostRepeated = array_slice($counted, 0, $this->wordsToSearch);

        foreach($mostRepeated as $word => $count) {
            $this->repeatedWords[] = ['word' => $word, 'quantity' => $count];
        }
    }

    public function getRepeatedWords()
    {
        $this->splitText();
        $this->removeIgnoreWords();
        $this->setRepeatedWords();

        return $this->repeatedWords;
    }
}