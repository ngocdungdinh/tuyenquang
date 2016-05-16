<div class="shared_social clearfix" style="display: inline-block">
	<ul>
		<li>
			|
			<a target="_blank" href="/print/{{ $post->slug }}-{{$post->id}}" class="btn btn-xs btn-default">
                <i class="fa fa-print"></i>
            </a>
		</li>
		<li>
			<a target="_blank" href="mailto:?subject=Bài viết này khá hay và hữu ích&amp;body=Hi%2c%0d%0a%0a{{ $post->url() }}">
                <img src="/assets/img/social/share-email.gif">
            </a>
		</li>
		<li class="plusone">
			<!-- Đặt thẻ này vào nơi bạn muốn Nút +1 kết xuất. -->
			<div class="g-plusone" data-size="medium"></div>
			<!-- Đặt thẻ này sau thẻ Nút +1 cuối cùng. -->
			<script type="text/javascript">
			  window.___gcfg = {lang: 'vi'};

			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		</li>
		<li class="facebook">
			<div class="fb-like" data-href="{{ $post->url() }}" data-width="100" data-height="" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-send="false"></div>
		</li>
	</ul>
</div>