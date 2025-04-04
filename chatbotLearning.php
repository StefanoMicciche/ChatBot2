<?php

class LearningSystem{
    private $dbFile = 'data/learned_responses.json';

    public function learn($question, $answer){
        $learned = json_decode(file_get_contents($this->dbFile), true) ?? [];
        $learned[$question] = $answer;
        file_put_contents($this->dbFile, json_encode($learned));
    }

    public function getLearnedResponse($question){
        $learned = json_decode(file_get_contents($this->dbFile), true) ?? [];
        return $learned[$question] ?? null;
    }
}
?>