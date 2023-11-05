@extends('layouts.master')
@section('content')
    
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Facebook Posts</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                    @foreach($groupedPosts as $index => $tags)
                      <li class="nav-item  ">
                        <a class="nav-link {{$loop->first ? 'active' : ''}}" id="{{ Str::slug($tags[0]) }}-tab" data-toggle="tab" href="#{{ Str::slug($tags[0]) }}" role="tab"
                          aria-controls="{{ Str::slug($tags[0]) }}" aria-selected="true">{{str_replace('#',' ',$index)}}</a>
                      </li>
                    @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent2">
               @foreach($groupedPosts as $index => $tags)
                  @php
                  @endphp
                     <div class="tab-pane fade {{$loop->first ? 'show active':''}}" id="{{ Str::slug($tags[0])}}" role="tabpanel" aria-labelledby="{{ Str::slug($tags[0]) }}-tab">
                    <div class="row">
                    <div class="col-12">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Post Id</th>
                                <th scope="col">Message</th>
                                <th scope="col">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($tags as $post)
                                   @php
                                $content = json_decode($post->content);
                                @endphp
                                <tr>
                                <th scope="row">1</th>
                                <td>{{$post->user->name}}</td>
                                  <td>
                     <img alt="image" src="https://static.vecteezy.com/system/resources/previews/009/734/564/original/default-avatar-profile-icon-of-social-media-user-vector.jpg" class="rounded-circle" width="70"
                        data-toggle="tooltip" title="{{$post->user->name}}">
                    </td>
                                <td><a href="https://www.facebook.com/{{$post->userAccount->username}}/posts/{{$post->post_id}}" target="_blank">{{$post->post_id}}</a></td>
                                <td>
                                  @if($content->message)
                                  {{ preg_replace('/#\w+/', '',  $content->message)}}
                                   @endif
                                </td>

                                <td>
                                  {{isset($post->category) ? $post->category : 'Not Specified'}}
                                </td>
                                </tr>
                             @endforeach
                            </tbody>
                            </table>
                    </div>
                    </div>
                      </div>
                    @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection