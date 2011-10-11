/**
 * 
 */
var Questions = {
		_newFlowState:null,
		loadQuestions: function(state){
			alert(state);
			Questions._newFlowState = state;
			$(".ajaxContent").hide('slide',{direction:'left'},500);
			$(".ajaxContent").empty();
			currentForm = $(".questions_"+Questions._newFlowState+".form").clone();
			$(".ajaxContent").html(currentForm);
			$(".ajaxContent").show('slide',{direction:'right'},700);
			
		},
		submitQuestions:function(){
			postData = $(".ajaxContent .questions_"+Questions._newFlowState+".form").serialize();
			var form =  $(".questions_"+Questions._newFlowState+".form");
			//alert(postData);
			$.ajax({
				url:"/profile/submit-questions",
				type:"POST",
				data:postData,
				success:function(){
					++Questions._newFlowState;
					if(Questions._newFlowState < 5)
						Questions.loadQuestions(Questions._newFlowState);
					else{
						window.location="/profile";
					}
				}
			})
		},
		showQuestions:function(){
			Dialog.showDialog({renderAction:"/profile/questions"})
		}
}

