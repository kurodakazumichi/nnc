<script type="text/javascript">
  $(function(){

      var r = new marked.Renderer();
      r.heading = function(text, level) {
        level += 1;
        level = Math.max(2, level);
        return '<h'+level+'>'+text+'</h'+level+'>';
      };

      marked.setOptions({
        gfm:false,
        renderer:r
      });

      var htmlText = marked($('article').html());

      $('article').html(htmlText);

      $('article').find("h2, h3, h4, h5, h6").each(function(){
        var a = $(this);

        a.nextUntil(a.prop("tagName")).addBack().wrapAll("<section></section>");

      });
  });



</script>
<article class="note">
<?= $article->note->body; ?>
</article>
