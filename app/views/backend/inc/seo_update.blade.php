<div class="form-group">
    {{Form::label('seo_title')}}  
    {{ Form::text('seo_title', $seo->title ,array('class'=>'form-control', 'placeholder'=>'SEO Title'))}}
  </div>

  <div class="form-group">
    {{ Form::label('seo_keywords')}}  
    {{ Form::text('seo_keywords', $seo->keywords ,array('class'=>'form-control', 'placeholder'=>'SEO Keywords'))}}
  </div>
  
  <div class="form-group">
    {{ Form::label('seo_description')}}  
    {{ Form::textarea('seo_description', $seo->description ,array('class'=>'form-control', 'placeholder'=>'SEO Description','rows' => 4))}}
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#seo_title").charCounter(70,{
        container: '<small></small>'
      });

      $("#seo_description").charCounter(160,{
        container: '<small></small>'
      });

      $("#seo_keywords").charCounter(255,{
        container: '<small></small>'
      });
    });
  </script>