<!DOCTYPE html>
<html>
  <head>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />
    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>
    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <script>
        // Ensure CSRF token is sent with AJAX requests
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }
                   );

        // Added Pusher logging
        Pusher.log = function(msg)
                     {
                       console.log(msg);
                     };
    </script>
  </head>
  
  <body>
	<div class="stripe no-padding-bottom numbered-stripe">
	    <div class="fixed wrapper">
	        <ol class="strong" start="1">
	            <li>
	                <div class="hexagon"></div>
	                <h2><b>Real-Time Notifications</b> <small>Let users know what's happening.</small></h2>
	            </li>
	        </ol>
	    </div>
	</div>

	<section class="blue-gradient-background splash">
	    <div class="container center-all-container">
	        <form id="notify_form" action="/notifications/notify" method="post">
	            <input type="text" id="notify_text" name="notify_text"
	                   placeholder="What's the notification?" minlength="3" maxlength="140" required />
	        </form>
	    </div>
	</section>
	
	<script>
	function notifyInit()
	{
      // set up form submission handling
	  $('#notify_form').submit(notifySubmit);
	}

	// Handle the form submission
	function notifySubmit()
	{
	  var notifyText = $('#notify_text').val();
	  if(notifyText.length < 3)
	  {
	    return;
	  }

	  // Build POST data and make AJAX request
	  var data = {notify_text: notifyText};
	  $.post('/notifications/notify', data).success(notifySuccess);

	  // Ensure the normal browser event doesn't take place
	  return false;
	}

	// Handle the success callback
	function notifySuccess()
	{
	  console.log('notification submitted');
	}

	$(notifyInit);

	// Use toastr to show the notification
	function showNotification(data)
	{
      // TODO: get the text from the event data <--- I wonder why this tutorial does not have the code for it
      var text = data.text;

      // TODO: use the text in the notification <--- I wonder why this tutorial does not have the code for it
      toastr.options = {"closeButton": false,
    	                "debug": false,
    	                "newestOnTop": false,
    	                "progressBar": true,
    	                "positionClass": "toast-top-right",
    	                "preventDuplicates": false,
    	                "onclick": null,
    	                "showDuration": "300",
    	                "hideDuration": "1000",
    	                "timeOut": "5000",
    	                "extendedTimeOut": "1000",
    	                "showEasing": "swing",
    	                "hideEasing": "linear",
    	                "showMethod": "fadeIn",
    	                "hideMethod": "fadeOut"
        	          }
      toastr.success(text);
      //toastr.info('Are you the 6 fingered man?');  // if you want it in INFO type, known types are Success, Info, Warning, Error
    }

	var pusher = new Pusher('{{env("PUSHER_KEY")}}',
			                {
		                      cluster: '{{env("PUSHER_CLUSTER")}}',
		                      encrypted: true
			                }
			               );

	// TODO: Subscribe to the channel <--- I wonder why this tutorial does not have the code for it
	var channel = pusher.subscribe('notifications'); // subscribe to the "notifications" channel

	// TODO: Bind to the event and pass in the notification handler <--- I wonder why this tutorial does not have the code for it
    channel.bind('new-notification', showNotification);

	</script>
  </body>
</html>