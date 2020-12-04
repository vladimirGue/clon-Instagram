var url = 'http://blog.com.devel:8080';
$(document).ready(function(){

    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    
    function like(){
        //boton de like
        $('.btn-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/heart-red.png');

            $.ajax({
                url: url+'/like/'+$(this).attr('data-id'),
                type: 'GET',
                success: function(response){
                    if (response.like) {
                        console.log('has dado like');
                    }else{
                        console.log('error al dar like');
                    }
                    
                }
            });
            dislike();
        });
    }
    like();

    function dislike(){
        //boton de dislike
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/img/heart.png');

            $.ajax({
                url: url+'/dislike/'+$(this).attr('data-id'),
                type: 'GET',
                success: function(response){
                    if (response.like) {
                        console.log('has quitado tu like');
                    }else{
                        console.log('error al dar dislike');
                    }
                    
                }
            });
            like();
        });
    }
    dislike();
});