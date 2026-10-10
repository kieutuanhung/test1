@php
    $onAudit = request()->routeIs('sysadmin.audit.*');
@endphp

<style>
    .sa-tabs{display:flex;gap:.5rem;flex-wrap:wrap;border-bottom:1px solid #2e2e37;padding-bottom:.9rem;}
    .sa-tab{display:inline-flex;align-items:center;border:1px solid #3a3a45;background-color:#16161b;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.65rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
    .sa-tab:hover{border-color:#fff;color:#fff;}
    .sa-tab.is-active{border-color:#e0392c;color:#fff;background:linear-gradient(135deg,rgba(224,57,44,.30),rgba(242,106,46,.14));}
</style>

<nav class="sa-tabs" aria-label="Loại nhật ký">
    <a href="{{ route('sysadmin.logs.index') }}" class="sa-tab {{ !$onAudit ? 'is-active' : '' }}">Nhật ký đăng nhập</a>
    <a href="{{ route('sysadmin.audit.index') }}" class="sa-tab {{ $onAudit ? 'is-active' : '' }}">Hoạt động hệ thống</a>
</nav>
