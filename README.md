# Notes app by CongNT

1. <a href="#android-app">Android App</a>
    1. <a href="#call-functions-backend-in-app">Call functions backend in app</a>
2. <a href="#sql">SQL</a>
3. <a href="#functions">Functions</a>
    1. <a href="#registeruser">registerUser()</a>
    2. <a href="#loginuser">loginuser()</a>
    3. <a href="#runinsertnotes">runInsertNotes()</a>
    4. <a href="#runupdatenotes">runUpdateNotes()</a> 
    5. <a href="#rundeletenotes">runDeleteNotes()</a> 
    6. <a href="#receivenotesdata">receiveNotesData()</a> 

## Android App
https://github.com/trongcong/Notes
### Call functions backend in app
* REGISTER_OPERATION: 
<pre>
public static final String REGISTER_OPERATION = "register";
</pre>
* LOGIN_OPERATION: #code = "login"
* INSERTNOTES_OPERATION:  #code = "insertNotes"
* UPDATENOTES_OPERATION:  #code = "updateNotes"
* DELETENOTES_OPERATION:  #code = "deleteNotes"
* RECEIVENOTES_OPERATION:  #code = "receiveNotes"
<pre>
Retrofit retrofit = new Retrofit.Builder()
                .baseUrl(Constants.BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

RequestInterface requestInterface = retrofit.create(RequestInterface.class);

User user = new User();
user.setName(name);
user.setEmail(email);
user.setPassword(password);
user.setPassword(phone);

ServerRequest request = new ServerRequest();
request.setOperation(Constants.REGISTER_OPERATION);
request.setUser(user);
Call<ServerResponse> response = requestInterface.operation(request);

response.enqueue(new Callback<ServerResponse>() {
    @Override
    public void onResponse(Call<ServerResponse> call, retrofit2.Response<ServerResponse> response) {
        #code...
    }
    @Override
    public void onFailure(Call<ServerResponse> call, Throwable t) {
        #code
    }
}
</pre>
### Class RequestInterface  
<pre>
public interface RequestInterface {
    // POST from client to server: register, login, insertNotes, updateNotes, deleteNotes
    // Server return result <a href="#functions">See functions</a>
    @POST("...path link/")
    Call<ServerResponse> operation(@Body ServerRequest request);

    // GET notes from server: receiveNotes
    // Server return result <a href="#receivenotesdata">See functions receiveNotesData</a>
    @GET("...path link/") 
    Call<List<Notes>> getNotes(@Query("operation") String operation, @Query("user_id") String user_id);
}
</pre>
### Class ServerRequest
<pre>
public class ServerRequest {

    private String operation;
    private User user;
    private Notes notes;

    public void setOperation(String operation) {
        this.operation = operation;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public void setNotes(Notes notes) {
        this.notes = notes;
    }
}
</pre>
### Class ServerResponse
<pre>
public class ServerResponse {

    private String result;
    private String message;
    private User user;
    private Notes notes;

    public String getResult() {
        return result;
    }

    public String getMessage() {
        return message;
    }

    public User getUser() {
        return user;
    }

    public Notes getNotes() {
        return notes;
    }
}
</pre>
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

### receiveNotesData()
<pre>
receiveNotesData($user_id) {
    # code...
}
</pre>

#### Response: 
* Success: Receive data successfully!
<pre>
{
    "result": "success",
    "message": "Receive data successfully!",
    "notes": [
        {
            "id": "4",
            "user_id": "599d9824b20f94.38318232",
            "notes_content": "I do!",
            "created_at": "2017-08-25 23:31:32",
            "last_update": "2017-08-25 23:31:32"
        } 
    ]
}
</pre>  
* Failure: Receive data failure or User has no data !
<pre>
{
    "result": "failure",
    "message": "Receive data failure or User has no data !"
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