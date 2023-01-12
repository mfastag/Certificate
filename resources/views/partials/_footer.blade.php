        <!-- Footer -->
<footer class="fixed-bottom py-2 bg-dark">
     <div class="container">
                  <p class="m-0 text-center text-white">Copyright &copy; <a target='s' href='http://www.elemcosoftware.com'>Elemco Software Integration Group Ltd</a> {{ date('Y') }}</p>

@if(Auth::check())
                <!--<a style='float:right' href="/logout">Logout</a>-->
@else
                <!--<a style='float:right' href="/login">Login</a>-->
@endif
                
                </div>
                <!-- /.container -->
</footer>
