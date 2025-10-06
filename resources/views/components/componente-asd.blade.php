{{-- @props(['id_modal' => 'miModal', 'usuario' => null]) --}}

<div class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog" aria-labelledby="{{ $idModal }}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{{ $idModal }}Label">TEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          {{ $slot }}
      </div>

      @isset($footer)
        {{ $footer }}
      @endisset
    </div>
  </div>
</div>