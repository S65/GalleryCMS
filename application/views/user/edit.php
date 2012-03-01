<?php $this->load->view('inc/header'); ?>

<h1>Update User</h1>
<?php
echo form_open("user/update/$user->id");

echo form_fieldset('User Information');

echo form_error('email_address');
echo form_label('Email Address', 'email_address');
echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'value' => $user->email_address));

echo form_error('password');
echo form_label('Password (leave blank to keep the same)', 'password');
echo form_password('password');

echo form_label('Is active?', 'is_active');
echo form_checkbox('is_active', '1', $user->is_active);

echo form_label('Is admin?', 'is_admin');
echo form_checkbox('is_admin', '1', $user->is_admin);

echo form_fieldset_close(); 

echo form_button(array('id' => 'submit', 'value' => 'Update', 'name' => 'submit', 'type' => 'submit', 'content' => 'Update','class' => 'btn btn-primary'));

echo form_close();
?>

<?php $this->load->view('inc/footer'); ?>