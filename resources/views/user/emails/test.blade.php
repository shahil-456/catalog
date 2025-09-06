
     <meta name="csrf-token" content="{{ csrf_token() }}">

 
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>

    var userId = {{ auth()->id() }};
    
    Pusher.logToConsole = true;

    var pusher = new Pusher('56433665da04336666f7', {
        cluster: 'ap2',
        authEndpoint: '/customer/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }
    });

    var channel = pusher.subscribe('private-amer-leads.' + userId);

    channel.bind('status-notify', function(data) {

        let msg = data.message.message;
        let sender = data.message.user_name ?? 'Unknown';
        let time = new Date().toLocaleTimeString();

        let notificationsList = document.getElementById('notificationsList');

        let newNotification = document.createElement('a');
        newNotification.href = "javascript:void(0);";
        newNotification.className = "block mb-4";
        newNotification.innerHTML = `
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center h-9 w-9 rounded-full text-white bg-primary">
                            <i class="mgc_message_3_line text-lg"></i>
                        </div>
                    </div>
                    <div class="flex-grow truncate ms-2">
                        <small class="noti-item-subtitle text-muted">${msg}</small>
                    </div>
                </div>
            </div>
        `;

        notificationsList.prepend(newNotification);
    
    
    });
</script>