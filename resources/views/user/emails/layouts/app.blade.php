<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title></title>


    <title>{{ $subjectLine }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 

   <style>
    body {
        background-color: #e9eff5;
        font-family: 'Segoe UI', sans-serif;
        padding: 40px;
    }

    .container {
        max-width: 650px;
        margin: auto;
    }


    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        padding: 24px 30px;
        font-size: 1.8rem;
        font-weight: bold;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

        .card {
        width: 400px;
        height: 400px;
        margin: 60px auto;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #dee2e6;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        transition: 0.4s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .card-body {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
    }


    p.lead {
        font-size: 1.15rem;
        color: #444;
        font-weight: 500;
        margin-bottom: 25px;
        line-height: 1.6;
        text-align: center;
    }

    
   h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #0d6efd;
        text-align: center;
        margin-top: 20px;
        padding: 10px 20px;
        background: #02335c70;
        border-radius: 12px;
        border: 1px solid #7be425;
        display: inline-block;
        transition: 0.3s;
    }
    
    h4:hover {
        background: #d0e3ff;
        color: #084298;
        cursor: pointer;
        transform: scale(1.03);
    }
</style>




    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap"
      rel="stylesheet"
      type="text/css"
    />
    
  </head>

  <body
    class="clean-body u_body"
    style="
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      background-color: #ecf0f1;
      color: #000000;
    "
  >
                           @yield('content')

  </body>
</html>
