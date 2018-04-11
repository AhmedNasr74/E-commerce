<h1 class="text-center">Edit Member</h1>
<div class="line"></div>
 <div class="container">
   <form method="post" action="?do=update" class="form-horizontal"><!--onsubmit="return validateForm()"-->
     <div class="form-group form-group-lg">
       <label class="col-sm-2">User Name</label>
       <div class="col-sm-10 col-md-4">
         <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $result['usernname']; ?>">
         <input type="hidden" name="oldname" value="<?php echo $result['usernname']; ?>">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Password</label>
       <div class="col-sm-10 col-md-4">
         <input type="hidden" name="oldpass" value="<?php echo $result['password'];?>">
         <input type="password" name="npass" class="form-control" placeholder="Leave It if you Don't want to change" autocomplete="new-password">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Email</label>
       <div class="col-sm-10 col-md-4">
         <input type="email" name="email" class="form-control" value="<?php echo $result['email']; ?>">
       </div>
     </div>

     <div class="form-group form-group-lg">
       <label class="col-sm-2">Full Name</label>
       <div class="col-sm-10 col-md-4">
         <input type="text" name="fname" class="form-control" value="<?php echo $result['fullname']; ?>">
       </div>
     </div>

     <div class="form-group">
       <div class="col-sm-offset-2 col-sm-10">
         <button class="btn btn-primary btn-lg" name="update">Save</button>
       </div>
     </div>
   </form>

 </div>
