<?php

namespace textSaveView;

class LayoutView {
    private $save = 'TextSave::Save';
    private $data = 'TextSave::Data';
    private $message;
    private $text;

    public function returnHTML(): string {
        return '
        <div>
            ' . $this->message . '
            <form method="post">
                <label for="' . $this->data . '">Enter text</label><br>
                <textarea rows="6" cols="50" name="' . $this->data . '">' . $this->text . '</textarea><br>
                <button name="' . $this->save . '">Save</button>
            </form>
        </div>
        ';
    }

    public function messageSaved(): void {
        $this->message = '<p>Saved your data.</p>';
    }

    public function isSaving(): bool {
        return isset($_POST[$this->save]);
    }

    public function getText(): string {
        return $_POST[$this->data];
    }

    public function setData(String $text): void {
        $this->text = $text;
    }
}
