<?php
echo '<h2>Users';
echo '<p>' . $html->link('Add User', array('action' => 'add')) . '</p>';
if (!empty($users)) {
    echo $form->create('User', array('action' => 'delete'));
    echo '<table width="100%">';
    echo '  <thead>';
    $cells = array(
        $form->checkbox(null, array('id' => 'select-all')),
        null,
        $this->Paginator->sort('Username', 'full_name'),
        $this->Paginator->sort('Email', 'email'),
        $this->Paginator->sort('Created', 'created'),
    );
    echo $this->Html->tableHeaders($cells);
    echo '  </thead>';
    echo '  <tbody>';
    foreach($users as $i) {
        $cells = array(
            $form->checkbox('User.delete.' . $i['User']['id']),
            $html->link('Edit', array('action' => 'edit', $i['User']['id'])),
            $i['User']['username'],
            $i['User']['email'],
            $i['User']['created'],
        );
        echo $this->Html->tableCells($cells, array('class' => 'odd'), array('class' => 'even'));
    }
    echo '  </tbody>';
    $numbers = $this->Paginator->numbers();
    if (!empty($numbers)) {
        $counter = $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
        $counter .= ' | '.$numbers.' | ';
        $counter .= $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
        echo '<tfoot>';
        echo $this->Html->tableCells(array(array(array($counter, array('colspan' => count($cells))))), null, null, true);
        echo '</tfoot>';
    }
    echo '</table>';
    echo $form->end('Delete Selected');
}
?>