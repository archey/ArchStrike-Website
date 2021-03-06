@extends('main')

@section('page')

<div class="container page-container">
    @if($package === false)
        <div class="row error-row">
            <div class="col-xs-12 col-md-10 error-column">
                <div class="page-wrapper">
                    <a href="/" title="Home"><img src="/img/archstrike.svg" class="img-responsive small-logo" /></a>
                    <div class="error">Package Does Not Exist</div>
                </div>
            </div>
        </div>
    @elseif($package === true)
        @if($packages !== false)
            <h1>Packages <a href="/builder" title="View a list of failed and incomplete builds" class="heading-link">Build Issues</a></h1>

            <form id="package-search">
                <input placeholder="" />
                <button type="button">Search</button>
            </form>

            <table class="packages-table">
                <thead>
                    <tr>
                        <th class="pcks-col">Package</th>
                        <th class="vers-col">Version</th>
                        <th class="desc-col">Description</th>
                        <th class="repo-col">Repository</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($packages))
                        @foreach($packages as $package)
                            @if(!empty($package['pkgdesc']))
                                <tr>
                                    <td class="pcks-col"><a href="/packages/{{ $package['package'] }}">{{ $package['package'] }}</a></td>
                                    <td class="vers-col">{{ $package['pkgver'] }}</td>
                                    <td class="desc-col">{{ $package['pkgdesc'] }}</td>
                                    <td class="repo-col">{{ $package['repo'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>

            @if($pages > 1)
                <p class="page-list">
                    @if($page > 1)
                        <a class="page-prev" href="/packages/page/{{ $page - 1 }}">Prev</a>
                    @endif

                    @for($x=1; $x<=$pages; $x++)
                        @if($x == $page)
                            <span class="current-page">{{ $x }}</span>
                        @else
                            <a class="page-link" href="/packages/page/{{ $x }}">{{ $x }}</a>
                        @endif
                    @endfor

                    @if($page < $pages)
                        <a class="page-next" href="/packages/page/{{ $page + 1 }}">Next</a>
                    @endif
                </p>
            @endif
        @else
            <div class="row error-row">
                <div class="col-xs-12 col-md-10 error-column">
                    <div class="page-wrapper">
                        <a href="/" title="Home"><img src="/img/archstrike.svg" class="img-responsive small-logo" /></a>
                        <div class="error">Page Does Not Exist</div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 column">
                <h1>{{ $package->package }}</h1>
                <table class="package-table">
                    <thead>
                        <tr>
                            <th colspan="2">Package Details:</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="architectures">
                            <th>Architectures:</th>
                            <td>
                                @if($skip_arch['all'])
                                    all
                                @else
                                    @foreach(['armv6', 'armv7', 'i686', 'x86_64'] as $arch)
                                        @if($skip_arch[$arch])
                                            <span>{{ $arch }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Description:</th>
                            <td>{{ $pkgdesc }}</td>
                        </tr>

                        <tr>
                            <th>Repository:</th>
                            <td>{{ $package->repo }}</td>
                        </tr>

                        <tr>
                            <th>Version:</th>
                            <td>{{ $package->pkgver }}-{{ $package->pkgrel }}</td>
                        </tr>

                        @if(!empty($package->provides))
                            <tr>
                                <th>Provides:</th>
                                <td>{{ $package->provides }}</td>
                            </tr>
                        @endif

                        <tr>
                            <th>Sources:</th>
                            <td>
                                <a href="https://github.com/ArchStrike/ArchStrike/blob/master/{{ $package->repo }}/{{ $package->package }}" target="_blank" rel="noopener noreferrer">Package Files</a> /
                                <a href="https://github.com/ArchStrike/ArchStrike/blob/master/{{ $package->repo }}/{{ $package->package }}/PKGBUILD" target="_blank" rel="noopener noreferrer">PKGBUILD</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="dependencies-table">
                    <thead>
                        <tr>
                            <th>Dependencies:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($package->depends))
                            @foreach(explode(' ', $package->depends) as $dep)
                                <tr>
                                    <td>{{ $dep }}</td>
                                </tr>
                            @endforeach
                        @endif

                        @if(!empty($package->makedepends))
                            @foreach(explode(' ', $package->makedepends) as $dep)
                                <tr>
                                    <td>{{ $dep }} (build)</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection
