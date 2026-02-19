@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div>
                    <h4 class="fw-semibold">Settings</h4>
                    <p class="mb-0 text-muted">Manage your notification and business preferences</p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('dashboard.settings.update') }}">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>VAT Registration</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center portse">
                            <div>
                                <div class="fs-18 fw-semibold text-primary mb-1">I am VAT registered</div>
                                <div class="text-muted fs-15">Enable this if your business is registered for VAT. This affects how profits are calculated in Profit/Loss analytics.</div>
                            </div>
                            <div class="form-check form-switch ms-4">
                                <input class="form-check-input" type="checkbox" role="switch" name="vat_registered" value="1" id="vatSwitch" {{ $settings->vat_registered ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>Discord Notifications</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-1">
                            <label class="form-label">Discord Webhook URL</label>
                            <input type="text" name="discord_webhook_url" class="form-control" placeholder="https://discord.com/api/webhooks/..." value="{{ old('discord_webhook_url', $settings->discord_webhook_url) }}">
                        </div>
                        <small class="text-muted">Create a webhook in your Discord server settings → Integrations → Webhooks</small>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 mt-3">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
