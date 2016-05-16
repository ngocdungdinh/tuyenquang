{{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} 
{{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }} 
<span>{{ $post->comment_count > 0 ? '<i class="fa fa-comments-o fa-red"> '. $post->comment_count.' </i>' : '' }}</span>