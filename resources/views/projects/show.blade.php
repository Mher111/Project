@extends('layouts.app')
@section('content')
    <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
        <!-- Jumbotron -->
        <div class="jumbotron">
            <h1>{{$project->name}}</h1>
            <p class="lead">{{$project->description}}</p>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
            {{--        <div class="sidebar-module sidebar-module-inset">--}}
            {{--            <h4>About</h4>--}}
            {{--            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>--}}
            {{--        </div>--}}
            <div class="sidebar-module">
                <h4>Actions</h4>
                <ol class="list-unstyled">
                    <li><a href="/projects/{{$project->id}}/edit">Edit</a></li>
                    <li><a href="/projects">List of projects</a></li>
                    <li><a href="/projects/create/">Create a new project</a></li>
                    <li><a href="/projects/create/{{$project->id}}">Add a new project</a></li>

                    <li><a
                            href=""
                            onclick="
                  var result = confirm('Are you sure you wish to delete this project?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                        >
                            Delete
                        </a>

                        <form id="delete-form" action="{{ route('projects.destroy',[$project->id]) }}"
                              method="POST" style="display: none;">
                            <input type="hidden" name="_method" value="delete">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <hr>
                    <h4>Add members</h4>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12  col-sm-12 ">
                            <form id="add-user" action="{{ route('projects.adduser') }}"  method="POST" >
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input class="form-control" name = "project_id" id="project_id" value="{{$project->id}}" type="hidden">
                                    <input type="text" required class="form-control" id="email"  name = "email" placeholder="Email">
                                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="addMember" >Add!</button>
                  </span>
                                </div><!-- /input-group -->
                            </form>
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->
                    <h4>Team members</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">Karen Petrosyan</a></li>
                    </ol>
                </ol>
            </div>


        </div>

        <div class="row  col-md-12 col-lg-12 col-sm-12" style="background: white; margin: 10px; ">
            <a href="/projects/create" class="pull-right btn btn-default btn-sm">Add Project</a>
            <form method="post" action="{{route('comments.store')}}">
                {{csrf_field()}}

                <div class="row container-fluid">

                    <form method="post" action="{{ route('comments.store') }}">
                        {{ csrf_field() }}


                        <input type="hidden" name="commentable_type" value="App\Project">
                        <input type="hidden" name="commentable_id" value="{{$project->id}}">


                        <div class="form-group">
                            <label for="comment-content">Comment</label>
                            <textarea placeholder="Enter comment"
                                      style="resize: vertical"
                                      id="comment-content"
                                      name="body"
                                      rows="3" spellcheck="false"
                                      class="form-control autosize-target text-left">
                            </textarea>
                        </div>


                        <div class="form-group">
                            <label for="comment-content">Proof of work done (Url/Photos)</label>
                            <textarea placeholder="Enter url or screenshots"
                                      style="resize: vertical"
                                      id="comment-content"
                                      name="url"
                                      rows="2" spellcheck="false"
                                      class="form-control autosize-target text-left">


                                          </textarea>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary"
                                   value="Submit"/>
                        </div>
                    </form>


                </div>

                         <div class="row">
                             <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">

                                 <!-- Fluid width widget -->
                                 <div class="panel panel-default">
                                     <div class="panel-heading">
                                         <h3 class="panel-title">
                                             <span class="glyphicon glyphicon-comment"></span> 
                                             Recent Comments
                                         </h3>
                                     </div>
                                     <div class="panel-body">
                                         <ul class="media-list">
                                             @foreach($project->comments as $comment)
                                                 <li class="media">
                                                     <div class="media-left">
                                                         <img src="http://placehold.it/60x60" class="img-circle">
                                                     </div>
                                                     <div class="media-body">
                                                         <h4 class="media-heading">
                                                            <p>{{$comment->user->name}}</p>
                                                            <p><a href="user/{{$comment->user->id}}">{{$comment->user->email}}</a></p>
                                                         </h4>
                                                         <p>{{$comment['body']}}</p>
                                                         <p>{{$comment['url']}}</p>
                                                         <small>
                                                             commented on  <p>{{$comment->created_at}}</p>
                                                         </small>
                                                     </div>
                                                 </li>
                                             @endforeach
                                         </ul>

                                     </div>
                                 </div>
                                 <!-- End fluid width widget -->

                             </div>
                         </div>




@endsection
