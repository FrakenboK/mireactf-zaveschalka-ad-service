<?php
class Will {
    public function __construct(array $attributes){
        foreach ($attributes as $name => $value) {
            $this->{$name} = $value;
        }
        $this->will_id = md5((string)microtime().getenv('SECRET'));
        $this->save();
    }

    private function save() {
        file_put_contents('./wills/'.$this->will_id, serialize($this));
    }
}