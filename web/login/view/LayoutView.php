<?php
namespace view;

class LayoutView {
    public function render($isLoggedIn, FormView $v, DateTimeView $dtv): string {
        return '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->register() . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $v->response($isLoggedIn) . '
              ' . $dtv->show() . '
          </div>
          ' . $this->textSave($isLoggedIn) . '
         </body>
      </html>
    ';
    }

    private function textSave($isLoggedIn) {
        if ($isLoggedIn) {
            $session = new \model\Session();
            $textSave = new \TextSave\TextSave($session->getSessionName());
            return $textSave->returnHTML();
        }
    }

    private function register(): string {
        if (isset($_GET['register'])) {
            return '<a href="?">Back to login</a>';
        } else {
            return '<a href="?register">Register a new user</a>';
        }
    }

    private function renderIsLoggedIn($isLoggedIn): string {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }
}
