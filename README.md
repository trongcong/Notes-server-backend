# Notes app by CongNT

1. <a href="#android-app">Android App</a>
2. <a href="#sql">SQL</a>
3. <a href="#functions">Functions</a>
    1. <a href="#registeruser">registerUser()</a>
    2. <a href="#loginuser">loginuser()</a>
    3. <a href="#runinsertnotes">runInsertNotes()</a>
    4. <a href="#runupdatenotes">runUpdateNotes()</a> 
    5. <a href="#rundeletenotes">runDeleteNotes()</a> 

## Android App
https://github.com/trongcong/Notes


## SQL
- Cấu trúc bảng cho bảng `users`
<pre>
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unique_id` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` text NOT NULL,
  `phone` tinytext,
  `status` tinytext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `salt` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
</pre> 
- Chỉ mục cho bảng `users` 
<pre>
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
</pre> 

- Cấu trúc bảng cho bảng `notes` 
<pre>
CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `content_note` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
</pre> 
- Chỉ mục cho bảng `notes` 
<pre>
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);
</pre>
## Functions
### registerUser()
<pre>
function registerUser($name, $email, $password, $phone){
    #code...
}
</pre>
#### Response: 
* Success
<pre>
{
    "result": "success",
    "message": "User Registered Successfully !"
}
</pre>
* Failure: User Already Registered !
<pre>
{
    "result": "failure",
    "message": "User Already Registered !"
}
</pre>
* Failure: Parameters should not be empty !
<pre>
{
    "result": "failure",
    "message": "Parameters should not be empty !"
}
</pre>
* Failure: Registration Failure
<pre>
{
    "result": "failure",
    "message": "Registration Failure"
}
</pre>

### loginUser()
<pre>
function loginUser($email, $password){
    #code...
}
</pre>
#### Response: 
* Success
<pre>
{
    "result": "success",
    "message": "Login Successful",
    "user": {
        "name": "Cờ Ông Công",
        "email": "trongcong96@gmail.com",
        "phone": "0987485414",
        "unique_id": "599071705f9b23.37861713"
    }
}
</pre>
* Failure: Invalid Login Credentials
<pre>
{
    "result": "failure",
    "message": "Invalid Login Credentials"
}
</pre>
* Failure: Parameters should not be empty !
<pre>
{
    "result": "failure",
    "message": "Parameters should not be empty !"
}
</pre> 

### runInsertNotes()

<pre>
runInsertNotes($user_id, $notes_content){
    #code
}
</pre>

#### Response: 
* Success
<pre>
{
    "result": "success",
    "message": "Notes Insert Successfully !"
}
</pre>
* Failure: User not exist !
<pre>
{
    "result": "failure",
    "message": "User not exist !"
}
</pre>
* Failure: Parameters should not be empty !
<pre>
{
    "result": "failure",
    "message": "Parameters should not be empty !"
}
</pre>
* Failure: Notes Insert Failure
<pre>
{
    "result": "failure",
    "message": "Notes Insert Failure"
}
</pre>

### runUpdateNotes()
<pre>
runUpdateNotes($notes_id, $user_id, $notes_content) {
    # code...
}
</pre>
#### Response: 
* Success
<pre>
{
    "result": "success",
    "message": "Notes Update Successfully !"
}
</pre>
* Failure: User not exist !
<pre>
{
    "result": "failure",
    "message": "User not exist !"
}
</pre>
* Failure: Notes not exist !
<pre>
{
    "result": "failure",
    "message": "Notes not exist !"
}
</pre>
* Failure: Parameters should not be empty !
<pre>
{
    "result": "failure",
    "message": "Parameters should not be empty !"
}
</pre>
* Failure: Notes Update Failure
<pre>
{
    "result": "failure",
    "message": "Notes Update Failure"
}
</pre>

### runDeleteNotes()
<pre>
runDeleteNotes($notes_id, $user_id) {
    # code...
}
</pre>

#### Response: 
* Success
<pre>
{
    "result": "success",
    "message": "Notes Deleted Successfully !"
}
</pre>
* Failure: User not exist !
<pre>
{
    "result": "failure",
    "message": "User not exist !"
}
</pre>
* Failure: Notes not exist !
<pre>
{
    "result": "failure",
    "message": "Notes not exist !"
}
</pre>
* Failure: Parameters should not be empty !
<pre>
{
    "result": "failure",
    "message": "Parameters should not be empty !"
}
</pre>
* Failure: Notes Delete Failure
<pre>
{
    "result": "failure",
    "message": "Notes Delete Failure"
}
</pre>
