# Notes app by CongNT

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