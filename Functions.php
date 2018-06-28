<?php
require_once 'DBOperations.php';

class Functions {
	private $db;

	public function __construct() {
		$this->db = new DBOperations();
	}

	public function runInsertNotes( $user_id, $notes_content ) {
		# code...
		$db            = $this->db;
		$user_id       = trim( $user_id );
		$notes_content = trim( $notes_content );

		if ( ! empty( $user_id ) && ! empty( $notes_content ) ) {
			if ( $db->checkUserExist( $user_id ) ) {
				$result = $db->insertNotes( $user_id, $notes_content );
				if ( $result ) {
					$response["result"]  = "success";
					$response["message"] = "Notes Insert Successfully !";

					return json_encode( $response );
				} else {
					$response["result"]  = "failure";
					$response["message"] = "Notes Insert Failure";

					return json_encode( $response );
				}
			} else {
				$response["result"]  = "failure";
				$response["message"] = "User not exist !";

				return json_encode( $response );
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function getMsgParamNotEmpty() {
		$response["result"]  = "failure";
		$response["message"] = "Parameters should not be empty !";

		return json_encode( $response );
	}

	public function runUpdateNotes( $notes_id, $user_id, $notes_content ) {
		# code...
		$db            = $this->db;
		$notes_id      = trim( $notes_id );
		$user_id       = trim( $user_id );
		$notes_content = trim( $notes_content );

		if ( ! empty( $notes_id ) && ! empty( $user_id ) && ! empty( $notes_content ) ) {
			if ( $db->checkUserExist( $user_id ) ) {
				if ( ! $db->checkNotesExist( $notes_id ) ) {
					# code...
					$result = $db->updateNotes( $notes_id, $user_id, $notes_content );
					if ( $result ) {
						$response["result"]  = "success";
						$response["message"] = "Notes Update Successfully !";

						return json_encode( $response );
					} else {
						$response["result"]  = "failure";
						$response["message"] = "Notes Update Failure";

						return json_encode( $response );
					}
				} else {
					# code...
					$response["result"]  = "failure";
					$response["message"] = "Notes not exist !";

					return json_encode( $response );
				}
			} else {
				$response["result"]  = "failure";
				$response["message"] = "User not exist !";

				return json_encode( $response );
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function runDeleteNotes( $notes_id, $user_id ) {
		# code...
		$db       = $this->db;
		$notes_id = trim( $notes_id );
		$user_id  = trim( $user_id );

		if ( ! empty( $notes_id ) && ! empty( $user_id ) ) {
			if ( $db->checkUserExist( $user_id ) ) {
				if ( ! $db->checkNotesExist( $notes_id ) ) {
					# code...
					$result = $db->deleteNotes( $notes_id, $user_id );
					if ( $result ) {
						$response["result"]  = "success";
						$response["message"] = "Notes Deleted Successfully !";

						return json_encode( $response );
					} else {
						$response["result"]  = "failure";
						$response["message"] = "Notes Deleted Failure";

						return json_encode( $response );
					}
				} else {
					# code...
					$response["result"]  = "failure";
					$response["message"] = "Notes not exist !";

					return json_encode( $response );
				}
			} else {
				$response["result"]  = "failure";
				$response["message"] = "User not exist !";

				return json_encode( $response );
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function registerUser( $name, $email, $password, $phone ) {
		$db       = $this->db;
		$name     = trim( $name );
		$email    = trim( $email );
		$password = trim( $password );
		$phone    = trim( $phone );

		if ( ! empty( $name ) && ! empty( $email ) && ! empty( $password ) && ! empty( $phone ) ) {
			if ( $db->checkUserExist( $email ) ) {
				$response["result"]  = "failure";
				$response["message"] = "User Already Registered !";

				return json_encode( $response );
			} else {
				$result = $db->insertUser( $name, $email, $password, $phone );
				if ( $result ) {
					$response["result"]  = "success";
					$response["message"] = "User Registered Successfully !";

					return json_encode( $response );
				} else {
					$response["result"]  = "failure";
					$response["message"] = "Registration Failure";

					return json_encode( $response );
				}
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function loginUser( $emailORphone, $password ) {
		$db           = $this->db;
		$emailORphone = trim( $emailORphone );
		$password     = trim( $password );

		if ( ! empty( $emailORphone ) && ! empty( $password ) ) {
			if ( $db->checkUserExist( $emailORphone ) ) {
				$result = $db->checkLogin( $emailORphone, $password );
				if ( ! $result ) {
					$response["result"]  = "failure";
					$response["message"] = "Invalid Login Credentials";

					return json_encode( $response );
				} else {
					$response["result"]  = "success";
					$response["message"] = "Login Successful";
					$response["user"]    = $result;

					return json_encode( $response );
				}
			} else {
				$response["result"]  = "failure";
				$response["message"] = "Invalid Login Credentials";

				return json_encode( $response );
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function receiveNotesData( $user_id ) {
		# code...
		$db      = $this->db;
		$user_id = trim( $user_id );
		if ( ! empty( $user_id ) ) {
			if ( $db->checkUserExist( $user_id ) ) {
				$result = $db->getNotesByUser( $user_id );
				if ( ! $result ) {
					$response["result"]  = "failure";
					$response["message"] = "Receive data failure or User has no data !";

					return json_encode( $response );
				} else {
					$response["result"]  = "success";
					$response["message"] = "Receive data successfully!";
					$response["notes"]   = $result;

					return json_encode( $response );
				}
			} else {
				$response["result"]  = "failure";
				$response["message"] = "User not exist !";

				return json_encode( $response );
			}
		} else {
			return $this->getMsgParamNotEmpty();
		}
	}

	public function isEmailValid( $email ) {
		return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

	public function getMsgInvalidParam() {
		$response["result"]  = "failure";
		$response["message"] = "Invalid Parameters";

		return json_encode( $response );
	}

	public function getMsgInvalidEmail() {
		$response["result"]  = "failure";
		$response["message"] = "Invalid Email";

		return json_encode( $response );
	}

}
