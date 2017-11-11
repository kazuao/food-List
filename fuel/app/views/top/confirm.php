<div class="container">

  <div class="row">
    <div class="confirm">
      <p>
        名前:<br>
        <?= $input['name']; ?>
      </p>
      <p>
        メールアドレス:<br>
        <?= $input['email']; ?>
      </p>
      <p>
        コメント:<br>
        <?= nl2br($input['comment']); ?>
      </p>

      <?php
        echo Form::open('top/inquiry');
        echo Form::hidden('name',    $input['name']);
        echo Form::hidden('email',   $input['email']);
        echo Form::hidden('comment', $input['comment']);
      ?>
      <div class="actions">
        <?= Form::submit('submit1', "修正",['class' => 'btn btn-default']); ?>
      </div>
      <?php
        echo Form::close();

        echo Form::open('top/send');

        // CSRF対策
        echo Form::csrf();

        echo Form::hidden('name',    $input['name'],    ['id' => 'name']);
        echo Form::hidden('email',   $input['email'],   ['id' => 'email']);
        echo Form::hidden('comment', $input['comment'], ['id' => 'comment']);
      ?>
      <div class="actions">
        <?= Form::submit('submit2', '送信',['class' => 'btn btn-primary']); ?>
      </div>
      <?= Form::close(); ?>
    </div>
  </div>

</div>
