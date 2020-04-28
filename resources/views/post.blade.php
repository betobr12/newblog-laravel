@extends('layouts.frontend.app')

@section('title','Post')



@push('css')

<link href="{{ asset('assets/frontend/single-post/styles.css') }}" rel="stylesheet">

<link href="{{ asset('assets/frontend/single-post/responsive.css') }}" rel="stylesheet">
<style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{ Storage::disk('public')->url('post/'.$post->image) }});
            background-size: cover;
        }
        .favorite_posts{
            color: blue;
        }
</style>


@endpush

@section('content')

<div class="header-bg ">

</div><!-- slider -->

<section class="post-area section">

    <div class="container">

        <div class="row">

            <div class="col-lg-16 col-md-12 no-right-padding">

                <div class="main-post">

                    <div class="blog-post-inner">

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="{{ route('author.profile', $post->user->username) }}"><img src="{{ Storage::disk('public')->url('profile/').$post->user->image }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="{{ route('author.profile', $post->user->username) }}"><b>{{ $post->user->name }}</b></a>
                                <h6 class="date">on {{ $post->created_at->diffForHumans() }}</h6>
                            </div>

                        </div><!-- post-info -->

                        <h3 class="title"><a href="#"><b>{{ $post->title }}</b></a></h3>

                        <div class="para">
                            {!! html_entity_decode($post->body) !!}
                        </div>

                        <div class="tag-area">
                            <ul>

                                @foreach ($post->categories as $category)

                                <li><a href="{{ route('category.posts',$category->slug) }}">{{ $category->name }}</a></li>

                                @endforeach

                            </ul>

                        </div>
                    </div><!-- blog-post-inner -->

                    <div class="post-icons-area">
                        <ul class="post-icons">
                            <li>
                                @guest
                                <a href="javascript:void(0);"onclick="toastr.info('Para adicionar aos favoritos, você precisa estar logado!','Info',{
                                        closeButon:true,
                                        progressBar:true,
                                    })">
                                    <i class="ion-heart">
                                        </i>{{ $post->favorite_to_users->count() }}</a>
                                @else
                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                    class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                 <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none;">
                                     @csrf
                                 </form>
                                @endguest

                            </li>
                            <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                            <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                        </ul>

                        <ul class="icons">
                            <li>COMPARTILHE : </li>

                            <li><i><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-lang="pt" data-show-count="false"></a></i></li>

                        </ul>
                    </div>

                    <div class="post-info">

                        <div class="left-area">
                            <a class="avatar" href="{{ route('author.profile', $post->user->username) }}"><img src="{{ Storage::disk('public')->url('profile/').$post->user->image }}" alt="Profile Image"></a>
                        </div>

                        <div class="middle-area">
                            <a class="name" href="{{ route('author.profile', $post->user->username) }}"><b>{{ $post->user->name }}</b></a>
                            <h6 class="date">on {{ $post->created_at->diffForHumans() }}</h6>
                        </div>

                    </div>


                </div><!-- main-post -->
            </div><!-- col-lg-8 col-md-12 -->



            <div class="col-lg-16 col-md-12 no-left-padding">

                <div class="single-post info-area">

                    <div class="sidebar-area about-area">

                        <br>

                        <h4 class="title"><b>Sobre o Autor</b></h4>
                        <p>{{ $post->user->about }}</p>


                    </div>

                    <div class="tag-area">

                        <h4 class="title"><b>TAGS</b></h4>
                        <ul>

                            @foreach ($post->tags as $tag)

                            <li><a href="{{ route('tag.posts',$tag->slug) }}">{{ $tag->name }}</a></li>

                            @endforeach

                        </ul>

                    </div><!-- subscribe-area -->

                </div><!-- info-area -->

            </div><!-- col-lg-4 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- post-area -->


<section class="recomended-area section">
    <div class="container">
        <div class="row">

            @foreach ($randomposts as $randompost)

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="single-post post-style-1">

                        <div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'.$randompost->image) }}" alt="{{ $randompost->title }}"></div>

                        <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profile/').$randompost->user->image }}" alt="Profile Image"></a>

                        <div class="blog-info">

                            <h4 class="title"><a href="{{ route('post.details',$randompost->slug) }}"><b>{{ $randompost->title }}</b></a></h4>

                            <ul class="post-footer">
                                <li>
                                    @guest
                                    <a href="javascript:void(0);"onclick="toastr.info('Para adicionar aos favoritos, você precisa estar logado!','Info',{
                                            closeButon:true,
                                            progressBar:true,
                                        })">
                                        <i class="ion-heart">
                                            </i>{{ $randompost->favorite_to_users->count() }}</a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $randompost->id }}').submit();"
                                        class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$randompost->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $randompost->favorite_to_users->count() }}</a>

                                     <form id="favorite-form-{{ $randompost->id }}" method="POST" action="{{ route('post.favorite',$randompost->id) }}" style="display: none;">
                                         @csrf
                                     </form>
                                    @endguest

                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{ $randompost->comments->count() }}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{ $randompost->view_count }}</a></li>
                            </ul>

                        </div><!-- blog-info -->
                    </div><!-- single-post -->
                </div><!-- card -->
            </div><!-- col-lg-4 col-md-6 -->

            @endforeach

        </div><!-- row -->

    </div><!-- container -->
</section>

<section class="comment-section">
    <div class="container">
        <h4><b>COMENTARIOS</b></h4>
        <div class="row">

            <div class="col-lg-16 col-md-12">
                <div class="comment-form">
                   @guest
                    <p>
                        Para inserir um novo comentario, você precisa estar
                        <a href="{{ route('login') }}"><i>Logado!</i></a>
                    </p>
                    @else

                    <form method="post" action="{{ route('comment.store',$post->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="comment" rows="2" class="text-area-messge form-control"
                                    placeholder="Escreva seu comentario" aria-required="true" aria-invalid="false"></textarea >
                            </div><!-- col-sm-12 -->
                            <div class="col-sm-12">
                                <button class="submit-btn" type="submit" id="form-submit"><b>ENVIAR COMENTARIO</b></button>
                            </div><!-- col-sm-12 -->

                        </div><!-- row -->
                    </form>

                 @endguest
                </div><!-- comment-form -->

                <h4><b>COMENTARIOS({{ $post->comments->count() }})</b></h4>

                @if ($post->comments->count() > 0)

                @foreach ($post->comments as $comment)
                <div class="commnets-area">

                    <div class="comment">

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="{{ route('author.profile', $comment->user->username) }}"><img src="{{ Storage::disk('public')->url('profile/'.$comment->user->image) }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
                                <h6 class="date">on {{ $comment->created_at->diffForHumans() }}</h6>
                            </div>

                            <div class="right-area">
                                <h5 class="reply-btn" ><a href="#"><b>RESPONDER</b></a></h5>

                            </div>

                        </div><!-- post-info -->
                        <br>

                        <p>{{ $comment->comment }}</p>

                    </div>

                </div><!-- commnets-area -->
                @endforeach

                @else
                <div class="commnets-area">
                    <div class="comment">
                        <p> Sem comentarios para este post! :( </p>
                    </div>
                </div>

                @endif

            </div><!-- col-lg-8 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section>

@push('js')

<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

@endpush

@endsection
