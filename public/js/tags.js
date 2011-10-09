/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $('.tags').click(function(){
                $(this).toggleClass('tag_disable');

            });
            $('.close_tag').click(function(){
                $(this).removeClass('tag_disable');

            });


            $('.close_tags a').click(function(){
                $(this).addClass('tag_remove');
            });

     
});