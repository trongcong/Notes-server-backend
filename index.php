<?php
require_once 'Functions.php';
$fun = new Functions();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$data = json_decode( file_get_contents( "php://input" ) );
	if ( isset( $data->operation ) ) {
		$operation = $data->operation;
		if ( ! empty( $operation ) ) {
			if ( $operation == 'register' ) {
				if ( isset( $data->user ) && ! empty( $data->user ) && isset( $data->user->name ) && isset( $data->user->email ) && isset( $data->user->password ) && isset( $data->user->phone ) ) {
					$user     = $data->user;
					$name     = $user->name;
					$email    = $user->email;
					$password = $user->password;
					$phone    = $user->phone;
					if ( $fun->isEmailValid( $email ) ) {
						echo $fun->registerUser( $name, $email, $password, $phone );
					} else {
						echo $fun->getMsgInvalidEmail();
					}
				} else {
					echo $fun->getMsgInvalidParam();
				}
			} else if ( $operation == 'login' ) {
				if ( isset( $data->user ) && ! empty( $data->user ) && isset( $data->user->emailORphone ) && isset( $data->user->password ) ) {
					$user         = $data->user;
					$emailORphone = $user->emailORphone;
					$password     = $user->password;
					echo $fun->loginUser( $emailORphone, $password );
				} else {
					echo $fun->getMsgInvalidParam();
				}
			} else if ( $operation == 'insertNotes' ) {
				if ( isset( $data->notes ) && ! empty( $data->notes ) && isset( $data->notes->user_id ) && isset( $data->notes->notes_content ) ) {
					$notes         = $data->notes;
					$user_id       = $notes->user_id;
					$notes_content = $notes->notes_content;
					echo $fun->runInsertNotes( $user_id, $notes_content );
				} else {
					echo $fun->getMsgInvalidParam();
				}
			} else if ( $operation == 'updateNotes' ) {
				if ( isset( $data->notes ) && ! empty( $data->notes ) && isset( $data->notes->notes_id ) && isset( $data->notes->user_id ) && isset( $data->notes->notes_content ) ) {
					$notes         = $data->notes;
					$notes_id      = $notes->notes_id;
					$user_id       = $notes->user_id;
					$notes_content = $notes->notes_content;
					echo $fun->runUpdateNotes( $notes_id, $user_id, $notes_content );
				} else {
					echo $fun->getMsgInvalidParam();
				}
			} else if ( $operation == 'deleteNotes' ) {
				if ( isset( $data->notes ) && ! empty( $data->notes ) && isset( $data->notes->notes_id ) && isset( $data->notes->user_id ) ) {
					$notes    = $data->notes;
					$notes_id = $user->notes_id;
					$user_id  = $user->user_id;
					echo $fun->runDeleteNotes( $notes_id, $user_id );
				} else {
					echo $fun->getMsgInvalidParam();
				}
			}
		} else {
			echo $fun->getMsgParamNotEmpty();
		}
	} else {
		echo $fun->getMsgInvalidParam();
	}
} else if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

	if ( isset( $_GET['operation'] ) ) {
		if ( ! empty( $_GET['operation'] ) ) {
			if ( $_GET['operation'] == 'receiveNotes' ) {
				if ( isset( $_GET['user_id'] ) ) {
					$user_id = $_GET['user_id'];
					echo $fun->receiveNotesData( $user_id );
				} else {
					echo $fun->getMsgInvalidParam();
				}
			}
		} else {
			echo $fun->getMsgParamNotEmpty();
		}
	} else {
		echo $fun->getMsgInvalidParam();
	}
}
