<div class="contentpanel">
    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">
            <div class="panel-heading">
            </div>
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-3 text-center acumuladomesAction">
                            <a href="javascript:mensajes()">
                                <span class="cursorpointer">
                                    <img src="images/message.png" style="width: 60px; height: 63px;"/><br/>
                                    <span class="text-primary  cursorpointer">Ver Mensaje</span>
                                </span> 
                            </a> 
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="javascript:vistaenviarmensaje()">
                                <span class="cursorpointer">
                                    <img src="images/enviarmsg.png" style="width: 55px; height: 63px;"/><br/>
                                    <span class="text-primary  cursorpointer">Enviar Mensaje</span>
                                </span> 
                            </a> 
                        </div>
                    </div>
                    <div id="vistaenviuarmensaje"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('//mensajes/_alerta'); ?> 
<?php $this->renderPartial('//mensajes/_alertaMensajeCorrecto'); ?> 