<div class="col-lg-9 animated fadeInRight">
    <div class="mail-box-header">
        {{-- <form method="get" action="index.html" class="float-right mail-search">
            <div class="input-group">
                <input type="text" class="form-control form-control-sm" name="search" placeholder="Search email">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Search
                    </button>
                </div>
            </div>
        </form> --}}
        <h2>
            Enviados ({{ $emails->count() }})
        </h2>
        <div class="mail-tools tooltip-demo m-t-md">
            <div class="btn-group float-right">
                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

            </div>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

        </div>
    </div>
    <div class="mail-box">
        <table class="table table-hover table-mail">
            <tbody>
                @foreach ($emails as $email)
                    <tr class="unread">
                        <td class="mail-ontact"><a href="mail_detail.html">{{ $email->customer->name }}</a></td>
                        <td class="mail-subject"><a href="mail_detail.html">{{ $email->subject }}.</a></td>
                        <td class=""><i class="fa fa-paperclip"></i></td>
                        <td class="text-right mail-date">{{ $email->sent_at->diffForHumans() }}</td>
                    </tr>
                @endforeach

            {{-- <tr class="unread">
                <td class="check-mail">
                    <input type="checkbox" class="i-checks" checked>
                </td>
                <td class="mail-ontact"><a href="mail_detail.html">Jack Nowak</a></td>
                <td class="mail-subject"><a href="mail_detail.html">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                <td class=""></td>
                <td class="text-right mail-date">8.22 PM</td>
            </tr>
            <tr class="read">
                <td class="check-mail">
                    <input type="checkbox" class="i-checks">
                </td>
                <td class="mail-ontact"><a href="mail_detail.html">Facebook</a> <span class="label label-warning float-right">Clients</span> </td>
                <td class="mail-subject"><a href="mail_detail.html">Many desktop publishing packages and web page editors.</a></td>
                <td class=""></td>
                <td class="text-right mail-date">Jan 16</td>
            </tr> --}}
            </tbody>
        </table>
    </div>
</div>

