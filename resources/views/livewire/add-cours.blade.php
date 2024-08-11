<div>
    <form class="needs-validation" novalidate="">
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label" for="validationCustom04">Jour</label>
                <select class="form-select" id="validationCustom04" required="">
                    <option selected="" disabled="" value="">Choose...</option>
                    <option>Lundi</option>
                    <option>Mardi</option>
                    <option>Mercredi</option>
                    <option>Jeudi</option>
                    <option>Vendre</option>
                    <option>Samedi</option>
                    <option>Dimanche</option>
                </select>
                <div class="invalid-feedback">Please select a valid state.</div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="validationCustom03">Classe</label>
                <select class="js-example-basic-single col-sm-12">
                    <optgroup label="Developer">
                        <option value="AL">Alabama</option>
                        <option value="WY">Wyoming</option>
                    </optgroup>
                    <optgroup label="Designer">
                        <option value="WY">Peter</option>
                        <option value="WY">Hanry Die</option>
                        <option value="WY">John Doe</option>
                    </optgroup>
                </select>
                <div class="invalid-feedback">Please provide a valid city.</div>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label" for="validationCustom05">Professeur</label>
                <select class="js-example-basic-single col-sm-12">
                    <optgroup label="Developer">
                        <option value="AL">Alabama</option>
                        <option value="WY">Wyoming</option>
                    </optgroup>
                    <optgroup label="Designer">
                        <option value="WY">Peter</option>
                        <option value="WY">Hanry Die</option>
                        <option value="WY">John Doe</option>
                    </optgroup>
                </select>
                <div class="invalid-feedback">Please provide a valid zip.</div>
            </div>
            <div class="col-md-2 mb-3 clockpicker">
                <label class="form-label" for="validationCustom05">Heure Debut</label>
                <input class="form-control" type="text" value="08:00" /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                <div class="invalid-feedback">Please provide a valid zip.</div>
            </div>
            <div class="col-md-2 mb-3 clockpicker">
                <label class="form-label" for="validationCustom05">Heure Fin</label>
                <input class="form-control" type="text" value="10:00" /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                <div class="invalid-feedback">Please provide a valid zip.</div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Valider</button>
    </form>
</div>
