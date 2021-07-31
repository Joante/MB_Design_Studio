@extends('Web.Layout.master_layout')

@section('content')
    <section class="comming section-padding">
		<div class="v-middle">
			<div class="container">
				<div class="row text-center mb-45">
					<div class="col-md-12">
						<h6>Nuestro sitio esta bajo construccion</h6>
						<h2>Proximamente!</h2> 
					</div>
				</div>
				<div class="row text-center mb-45">
					<div class="col-6 offset-md-2 col-md-2">
						<div class="item">
							<div class="down">
								<h3 id="days">00</h3> </div>
							<div class="item-info">
								<h6>Dias</h6> </div>
						</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="item">
							<div class="down">
								<h3 id="hours">00</h3> </div>
							<div class="item-info">
								<h6>Horas</h6> </div>
						</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="item">
							<div class="down">
								<h3 id="minutes">00</h3> </div>
							<div class="item-info">
								<h6>Minutos</h6> </div>
						</div>
					</div>
					<div class="col-6 col-md-2">
						<div class="item">
							<div class="down">
								<h3 id="seconds">00</h3> </div>
							<div class="item-info">
								<h6>Segundos</h6> </div>
						</div>
					</div>
				</div>
				<div class="row text-center">
					<div class="offset-md-3 col-md-6">
						<p>Suscribete para nuestras ultimas noticias y articulos.</p>
						<form>
							<input type="email" name="email" placeholder="Email">
							<button>Suscribirse</button>
						</form>
					</div>
				</div>
				<div class="row text-center">
					<div class="go-back col-md-12">
						<a href='index.html'> <span><i class="ti-arrow-left" aria-hidden="true"></i></span>&nbsp; Volver al Home </a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('page-script')
    <script type="text/javascript">
        function countdown() {
            var now = new Date();
            var eventDate = new Date(2021, 8, 1);
            var currentTiime = now.getTime();
            var eventTime = eventDate.getTime();
            var remTime = eventTime - currentTiime;
            var s = Math.floor(remTime / 1000);
            var m = Math.floor(s / 60);
            var h = Math.floor(m / 60);
            var d = Math.floor(h / 24);
            h %= 24;
            m %= 60;
            s %= 60;
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;
            document.getElementById("days").textContent = d;
            document.getElementById("days").innerText = d;
            document.getElementById("hours").textContent = h;
            document.getElementById("minutes").textContent = m;
            document.getElementById("seconds").textContent = s;
            setTimeout(countdown, 1000);
        }
        countdown();
    </script>
@endsection