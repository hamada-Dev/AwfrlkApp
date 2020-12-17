@if (session('guest'))


    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i style="color: #fb0000;" class="material-icons">close</i>
        </button>


            <b> Success - </b>
           <span style="color: orangered">
               {{session('guest')}}
           </span>
    </div>
@endif
