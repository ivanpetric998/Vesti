<div class="single_sidebar">
    <h2><span>Najnovije vesti</span></h2>
    <ul class="spost_nav">

        @foreach($najnovije as $i)
            @component('partials.mala_vest',['i'=>$i])
            @endcomponent
        @endforeach

    </ul>
</div>
