<?php

namespace textSaveView;

class LayoutView {
    private $save = 'TextSave::Save';
    private $data = 'TextSave::Data';
    private $delete = 'TextSave::Delete';
    private $id = 'TextSave::Id';
    private $new = 'TextSave::New';

    private $message;
    private $posts;

    public function returnHTML(): string {
        return '
        <div>
            <h2>' . $this->message . '</h2>
            <form method="post">
                <button name="' . $this->new . '">Add New Post</button><br>
            </form><br><br>
            ' . $this->posts . '
        </div>
        ';
    }

    public function messageSaved(): void {
        $this->message = 'Saved your data.';
    }

    public function messageAddNewPost(): void {
        $this->message = 'Added new post.';
    }

    public function messageDeletedPost(): void {
        $this->message = 'Deleted post.';
    }

    public function addingNewPost(): bool {
        return isset($_POST[$this->new]);
    }

    public function isSaving(): bool {
        return isset($_POST[$this->save]);
    }

    public function isDeleting(): bool {
        return isset($_POST[$this->delete]);
    }

    public function getText(): string {
        return $_POST[$this->data];
    }

    public function getPost() {
        return new \textSaveModel\Post($_POST[$this->id], $_POST[$this->data], '');
    }

    public function setData(array $data): void {
        foreach ($data as $post) {
            $this->posts .= '
                <form method="post">
                    <input name="' . $this->id . '" value="' . $post->getId() . '" type="hidden">
                    <label for="' . $this->data . '">Last edited ' . $post->getDate() . '</label><br>
                    <textarea rows="6" cols="50" name="' . $this->data . '">' . $post->getText() . '</textarea><br>
                    <button name="' . $this->save . '">Save</button>
                    <button name="' . $this->delete . '">Delete</button>
                </form><br><br>';
        }
    }
}
