<style>
    .ck.ck-editor__main .ck-content {
     height: 239px;
   }
   </style>
@component('mail::message')
<h1>Project:- <span style="text-transform: capitalize;color:crimson">{{ $task->project->project_name }}</span></h1>
<hr style="width:100%;">
<h2>Task:- <span style="text-transform: capitalize;color:crimson">{{ $task->heading }}</span></h2>
<?php if($task->priority == 1){ ?>
    <p><label style="background-color: crimson;padding: 0px 8px 2px 7px;border-radius: 15px;color: white;">Prority :- High</label></p>
<?php }else if($task->priority == 2){ ?>
    <p><label style="background-color: #ffc107;padding: 0px 8px 2px 7px;border-radius: 15px;color: white;">Prority :- Medium</label></p>
<?php }else{ ?>
    <p><label style="background-color: #28a745;padding: 0px 8px 2px 7px;border-radius: 15px;color: white;">Prority :- Low</label></p>
<?php } ?>
<p>Assigned By:- <span style="color:crimson;text-transform: capitalize;">{{$task->AssignBy->name}}</span></p>
<p>Starting Date:- <span style="color:crimson;">{{date('Y-m-d', strtotime($task->start_date))}}</span></p>
<p>End Date:- <span style="color:crimson">{{date('Y-m-d', strtotime($task->due_date))}}</span></p>
<p>Task Description:- {{ strip_tags($task->description) }}</p>
<?php $url=''; 
if($user->role == 1){
    $url = url('/');
}elseif($user->role == 2){
    $url = url('/');
}elseif($user->role == 3){
    $url = url('/');
}elseif($user->role == 4){
    $url = url('/');
}
?>
@component('mail::button', ['url' => $url])
View Task
@endcomponent
Thanks,<br>


@endcomponent
