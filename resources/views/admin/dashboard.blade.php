@extends('layouts.master')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 box-col-7">
                    <div class="card">
                        <div class="card-header sales-chart card-no-border pb-0">
                            <h4>Booking Chart</h4>
                            <div class="sales-chart-dropdown">
                                <ul class="balance-data">
                                    <li><span class="circle bg-primary"></span><span class="f-light ms-1">Active</span>
                                    </li>
                                    <li><span class="circle bg-warning"></span><span class="f-light ms-1">Archive</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-2 pt-0">
                            <div class="sales-wrapper position-relative" style="min-height: 250px;">
                                <div id="bookingChart" style="min-height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 box-col-5 total-revenue-total-order">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="total-revenue mb-2"> <span>Total Active Bookings</span></div>
                                    <div class="total-chart m-0">
                                        <h3 class="f-w-600"> {{ $bookingCounts['active'] ?? 0 }} </h3>
                                        <img width='100'
                                            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSI1MTIiIGhlaWdodD0iNTEyIiB4PSIwIiB5PSIwIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgY2xhc3M9IiI+PGc+PHBhdGggZmlsbD0iIzljZmU2MCIgZD0iTTQ2OSA0NjUuNEgxODcuMmMtMjcuNiAwLTUzLjctMjIuNC01OC4zLTUwLjFMODIuNyAxMzMuNWMtNC41LTI3LjcgMTQuMi01MCA0MS44LTUwaDI4MS44YzI3LjcgMCA1My43IDIyLjQgNTguMyA1MGw0Ni4zIDI4MS44YzQuNSAyNy43LTE0LjMgNTAuMS00MS45IDUwLjF6IiBvcGFjaXR5PSIxIiBkYXRhLW9yaWdpbmFsPSIjZmViZTYwIiBjbGFzcz0iIj48L3BhdGg+PHBhdGggZmlsbD0iIzRhYzcxOSIgZD0iTTE4Ny4yIDQ2NS40SDQzYy0yNy42IDAtNDYuNC0yMi40LTQxLjgtNTAuMWw0Ni4zLTI4MS44YzQuNS0yNy43IDMwLjYtNTAgNTguMy01MGgxOC44Yy0yNy43IDAtNDYuNCAyMi40LTQxLjggNTBsNDYuMyAyODEuOGM0LjMgMjcuNyAzMC41IDUwLjEgNTguMSA1MC4xeiIgb3BhY2l0eT0iMSIgZGF0YS1vcmlnaW5hbD0iI2ZmODkxMiIgY2xhc3M9IiI+PC9wYXRoPjxwYXRoIGZpbGw9IiNmZmY3ZWUiIGQ9Im0xNjAuNSA0MTUuMS00MC4xLTI0NGMtMS43LTEwLjMgNS4zLTE4LjYgMTUuNi0xOC42aDI4MS40YzEwLjMgMCAyMCA4LjMgMjEuNyAxOC42bDQwLjEgMjQ0YzEuNyAxMC4zLTUuMyAxOC42LTE1LjYgMTguNkgxODIuMmMtMTAuMy4xLTIwLTguMy0yMS43LTE4LjZ6IiBvcGFjaXR5PSIxIiBkYXRhLW9yaWdpbmFsPSIjZmZmN2VlIiBjbGFzcz0iIj48L3BhdGg+PHBhdGggZmlsbD0iIzlmNzBmZCIgZD0ibTM4Ny4xIDI1Ni45IDExLjEgMTYuOWMuOCAxLjIgMiAyIDMuNCAyLjJsMTkuMSAyLjdjMy40LjUgNS40IDQuNSAzLjQgNi45bC0xMS4zIDEzLjFjLS44LjktMSAyLjMtLjYgMy42bDYuMiAxOC42YzEuMSAzLjMtMS45IDUuOC01LjEgNC4ybC0xOC4xLTguOGMtMS4zLS42LTIuNy0uNi0zLjcgMGwtMTUuMiA4LjhjLTIuNyAxLjUtNi41LTEtNi41LTQuMmwuMS0xOC42YzAtMS4zLS42LTIuNi0xLjctMy42bC0xNS42LTEzLjFjLTIuOC0yLjMtMi4xLTYuNCAxLjEtNi45bDE4LjItMi43YzEuMy0uMiAyLjMtMSAyLjctMi4ybDUuNi0xNi45Yy43LTMgNS0zIDYuOSAweiIgb3BhY2l0eT0iMSIgZGF0YS1vcmlnaW5hbD0iIzlmNzBmZCI+PC9wYXRoPjxnIGZpbGw9IiNmZjg5MTIiPjxwYXRoIGQ9Ik0yMDQuMSAyMjkuOWMtMzkuOC0uMy0zMi4xIDUuMy0zOS0zMy41LS43LTQuMiAyLjItNy42IDYuNC03LjZoMjUuOWM0LjIgMCA4LjIgMy40IDguOSA3LjZsNC4yIDI1LjljLjYgNC4yLTIuMiA3LjYtNi40IDcuNnpNMjk4LjEgMjI5LjljLTM5LjgtLjMtMzIuMSA1LjMtMzktMzMuNS0uNy00LjIgMi4yLTcuNiA2LjQtNy42aDI1LjljNC4yIDAgOC4yIDMuNCA4LjkgNy42bDQuMiAyNS45Yy42IDQuMi0yLjIgNy42LTYuNCA3LjZ6TTM5Mi4xIDIyOS45Yy0zOS44LS4zLTMyLjEgNS4zLTM5LTMzLjUtLjctNC4yIDIuMi03LjYgNi40LTcuNmgyNS45YzQuMiAwIDguMiAzLjQgOC45IDcuNmw0LjIgMjUuOWMuNiA0LjItMi4yIDcuNi02LjQgNy42ek0yMTcuOCAzMTMuN2MtMzkuOC0uMy0zMi4xIDUuMy0zOS0zMy41LS43LTQuMiAyLjItNy42IDYuNC03LjZoMjUuOWM0LjIgMCA4LjIgMy40IDguOSA3LjZsNC4yIDI1LjljLjcgNC4yLTIuMiA3LjYtNi40IDcuNnpNMzExLjggMzEzLjdjLTM5LjgtLjMtMzIuMSA1LjMtMzktMzMuNS0uNy00LjIgMi4yLTcuNiA2LjQtNy42aDI1LjljNC4yIDAgOC4yIDMuNCA4LjkgNy42bDQuMiAyNS45Yy43IDQuMi0yLjIgNy42LTYuNCA3LjZ6TTIzMS42IDM5Ny41Yy0zOS44LS4zLTMyLjEgNS4zLTM5LTMzLjUtLjctNC4yIDIuMi03LjYgNi40LTcuNmgyNS45YzQuMiAwIDguMiAzLjQgOC45IDcuNmw0LjIgMjUuOWMuNyA0LjItMi4yIDcuNi02LjQgNy42ek0zMjUuNiAzOTcuNWMtMzkuOC0uMy0zMi4xIDUuMy0zOS0zMy41LS43LTQuMiAyLjItNy42IDYuNC03LjZoMjUuOWM0LjIgMCA4LjIgMy40IDguOSA3LjZsNC4yIDI1LjljLjcgNC4yLTIuMiA3LjYtNi40IDcuNnpNNDE5LjYgMzk3LjVjLTM5LjgtLjMtMzIuMSA1LjMtMzktMzMuNS0uNy00LjIgMi4yLTcuNiA2LjQtNy42aDI1LjljNC4yIDAgOC4yIDMuNCA4LjkgNy42bDQuMiAyNS45Yy43IDQuMi0yLjIgNy42LTYuNCA3LjZ6IiBmaWxsPSIjNGFjNzE5IiBvcGFjaXR5PSIxIiBkYXRhLW9yaWdpbmFsPSIjZmY4OTEyIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGZpbGw9IiM5ZjcwZmQiIGQ9Ik0xNzYuOCAxMjAuNHYtOC4zYzE1LjMuMyAyNi0xMi45IDIzLjMtMjcuOS0yLjYtMTYuMS0xNy45LTI5LjItMzQtMjkuMi0xNS4zLS4zLTI2IDEyLjktMjMuMyAyNy45bC04LjIgMS4zYy0zLjctMTkuOSAxMS4yLTM4IDMxLjUtMzcuNiAyMCAwIDM4LjkgMTYuMiA0Mi4yIDM2LjIgMy42IDE5LjktMTEuMyAzOC0zMS41IDM3LjZ6TTI3MC44IDEyMC40di04LjNjMTUuMy4zIDI2LTEyLjkgMjMuMy0yNy45LTIuNi0xNi4xLTE3LjktMjkuMi0zNC0yOS4yLTE1LjMtLjMtMjYgMTIuOS0yMy4zIDI3LjlsLTguMiAxLjNjLTMuNy0xOS45IDExLjItMzggMzEuNS0zNy42IDIwIDAgMzguOSAxNi4yIDQyLjIgMzYuMiAzLjYgMTkuOS0xMS4zIDM4LTMxLjUgMzcuNnpNMzY0LjggMTIwLjR2LTguM2MxNS4zLjMgMjYtMTIuOSAyMy4zLTI3LjktMi42LTE2LjEtMTcuOS0yOS4yLTM0LTI5LjItMTUuMy0uMy0yNiAxMi45LTIzLjMgMjcuOWwtOC4yIDEuM2MtMy43LTE5LjkgMTEuMi0zOCAzMS41LTM3LjYgMjAgMCAzOC45IDE2LjIgNDIuMiAzNi4yIDMuNiAxOS45LTExLjMgMzgtMzEuNSAzNy42eiIgb3BhY2l0eT0iMSIgZGF0YS1vcmlnaW5hbD0iIzlmNzBmZCI+PC9wYXRoPjwvZz48L3N2Zz4=" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="total-revenue mb-2"> <span>Total Archive Bookings </span></div>
                                    <div class="total-chart m-0">
                                        <h3 class="f-w-600">{{ $bookingCounts['archive'] ?? 0 }}</h3>
                                        <img width='100'
                                            src="data:image/png;base64,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" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xxl-4 box-col-12">
                    <div class="card height-equal" style="height:calc(100% - 25px);">
                        <div class="card-body">
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-primary-light">
                                        <svg version="1.1" id="fi_167707" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                            style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <polygon style="fill:#E6BE94;"
                                                        points="487.781,484 23.781,484 23.781,268 119.782,268 255.781,132 391.784,268 487.781,268 		">
                                                    </polygon>
                                                </g>
                                                <g>
                                                    <rect x="207.781" y="388" style="fill:#996459;" width="96"
                                                        height="96"></rect>
                                                </g>
                                                <g>
                                                    <path style="fill:#4BB9EC;"
                                                        d="M301.781,356h-92c-1.105,0-2,0.895-2,2v30h96v-30C303.781,356.895,302.886,356,301.781,356z">
                                                    </path>
                                                </g>
                                                <g>
                                                    <path style="fill:#FF4F19;"
                                                        d="M329.617,68l13.039-19.562c1.633-2.453,1.789-5.609,0.398-8.211S338.953,36,336,36h-80
                                                                            c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h80c2.953,0,5.664-1.625,7.055-4.227s1.234-5.758-0.398-8.211L329.617,68z">
                                                    </path>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#5C546A;" d="M256,140c-4.422,0-8-3.578-8-8V28c0-4.422,3.578-8,8-8s8,3.578,8,8v104
                                                                                C264,136.422,260.422,140,256,140z"></path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <path style="fill:#FF4F19;"
                                                        d="M288.391,168.938c1.234-2.992,4.156-4.938,7.391-4.938h152c2.734,0,5.281,1.398,6.75,3.703l56,88
                                                                            c1.57,2.469,1.664,5.586,0.266,8.148c-1.406,2.555-4.094,4.148-7.016,4.148h-120c-2.125,0-4.156-0.844-5.656-2.344l-88-88
                                                                            C287.836,175.367,287.148,171.93,288.391,168.938z">
                                                    </path>
                                                </g>
                                                <g>
                                                    <path style="fill:#FF4F19;"
                                                        d="M223.391,168.938C222.156,165.945,219.234,164,216,164H64c-2.734,0-5.281,1.398-6.75,3.703l-56,88
                                                                            c-1.57,2.469-1.664,5.586-0.266,8.148C2.391,266.406,5.078,268,8,268h120c2.125,0,4.156-0.844,5.656-2.344l88-88
                                                                            C223.945,175.367,224.633,171.93,223.391,168.938z">
                                                    </path>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#E3001E;"
                                                            d="M391.891,275.891c-2.047,0-4.094-0.781-5.656-2.344L256,143.313L125.766,273.547
                                                                                c-3.125,3.125-8.188,3.125-11.313,0s-3.125-8.188,0-11.313l135.891-135.891c3.125-3.125,8.188-3.125,11.313,0l135.891,135.891
                                                                                c3.125,3.125,3.125,8.188,0,11.313C395.984,275.109,393.938,275.891,391.891,275.891z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <circle style="fill:#FFEBB7;" cx="256.001" cy="268" r="48">
                                                    </circle>
                                                </g>
                                                <g>
                                                    <path style="fill:#5C546A;" d="M256,236c-4.422,0-8,3.578-8,8v16h-16c-4.422,0-8,3.578-8,8s3.578,8,8,8h24c4.422,0,8-3.578,8-8
                                                                            v-24C264,239.578,260.422,236,256,236z"></path>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#4BB9EC;"
                                                            d="M375.781,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                                                                                v-32h-0.403C375.641,322.707,375.781,321.37,375.781,320z"></path>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;" d="M356,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                                                                                C384,304.562,371.438,292,356,292z M356,308c6.617,0,12,5.383,12,12v4h-24v-4C344,313.383,349.383,308,356,308z M344,348v-8h24v8
                                                                                H344z"></path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x="136.001" y="396" style="fill:#4BB9EC;" width="40"
                                                            height="48"></rect>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;"
                                                            d="M176,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                                                                                C184,391.578,180.422,388,176,388z M168,404v8h-24v-8H168z M144,436v-8h24v8H144z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x="63.782" y="396" style="fill:#4BB9EC;" width="40"
                                                            height="48"></rect>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;"
                                                            d="M103.781,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                                                                                C111.781,391.578,108.203,388,103.781,388z M95.781,404v8h-24v-8H95.781z M71.781,436v-8h24v8H71.781z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x="408" y="396" style="fill:#4BB9EC;" width="40"
                                                            height="48"></rect>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;"
                                                            d="M448,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                                                                                C456,391.578,452.422,388,448,388z M440,404v8h-24v-8H440z M416,436v-8h24v8H416z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x="335.782" y="396" style="fill:#4BB9EC;" width="40"
                                                            height="48"></rect>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;"
                                                            d="M375.781,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                                                                                C383.781,391.578,380.203,388,375.781,388z M367.781,404v8h-24v-8H367.781z M343.781,436v-8h24v8H343.781z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#4BB9EC;"
                                                            d="M447.563,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                                                                                v-32h-0.403C447.422,322.707,447.563,321.37,447.563,320z"></path>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;"
                                                            d="M427.781,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                                                                                C455.781,304.562,443.219,292,427.781,292z M427.781,308c6.617,0,12,5.383,12,12v4h-24v-4
                                                                                C415.781,313.383,421.164,308,427.781,308z M415.781,348v-8h24v8H415.781z">
                                                        </path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#4BB9EC;"
                                                            d="M103.563,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                                                                                v-32h-0.403C103.422,322.707,103.563,321.37,103.563,320z"></path>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;" d="M83.781,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                                                                                C111.781,304.562,99.219,292,83.781,292z M83.781,308c6.617,0,12,5.383,12,12v4h-24v-4C71.781,313.383,77.164,308,83.781,308z
                                                                                M71.781,348v-8h24v8H71.781z"></path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#4BB9EC;"
                                                            d="M175.344,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                                                                                v-32h-0.403C175.203,322.707,175.344,321.37,175.344,320z"></path>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#7E5C62;" d="M155.563,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                                                                                C183.563,304.562,171,292,155.563,292z M155.563,308c6.617,0,12,5.383,12,12v4h-24v-4C143.563,313.383,148.945,308,155.563,308z
                                                                                M143.563,348v-8h24v8H143.563z"></path>
                                                    </g>
                                                </g>
                                                <g>
                                                    <path style="fill:#7E5C62;"
                                                        d="M256,324c-30.879,0-56-25.121-56-56s25.121-56,56-56s56,25.121,56,56S286.879,324,256,324z
                                                                            M256,228c-22.055,0-40,17.943-40,40s17.945,40,40,40s40-17.943,40-40S278.055,228,256,228z">
                                                    </path>
                                                </g>
                                                <g>
                                                    <path style="fill:#7E5C62;" d="M288,348h-64c-13.234,0-24,10.766-24,24v112c0,4.422,3.578,8,8,8s8-3.578,8-8v-88h31.781v88h16v-88
                                                                            H296v88c0,4.422,3.578,8,8,8s8-3.578,8-8V372C312,358.766,301.234,348,288,348z M296,380h-80v-8c0-4.414,3.586-8,8-8h64
                                                                            c4.414,0,8,3.586,8,8V380z"></path>
                                                </g>
                                                <g>
                                                    <g>
                                                        <path style="fill:#5C546A;"
                                                            d="M504,492H8c-4.422,0-8-3.578-8-8s3.578-8,8-8h496c4.422,0,8,3.578,8,8S508.422,492,504,492z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Total Schools</span>
                                        <h2 class="f-w-600">{{ $schools ?? 0 }}</h2>
                                    </div>
                                </li>
                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-warning-light">
                                        <svg id="fi_7829198" height="512" viewBox="0 0 522.3 544" width="512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <g>
                                                    <path
                                                        d="m309.6 427.2v-105.1h-47.9v33h-107.5c-11.5.1-20.8 9.4-20.8 20.9v51.3c0 27.9 22.6 50.5 50.5 50.5h.1 75.2c27.9-.1 50.5-22.7 50.4-50.6z"
                                                        fill="#1f315f"></path>
                                                    <path
                                                        d="m261.8 481c-.8-19.1-16.4-34.1-35.5-34.1h-9.5c-19.1 0-34.7 15.1-35.4 34.2z"
                                                        fill="#efcdb1"></path>
                                                    <path
                                                        d="m221.5 446.4c-3.3-.1-5.9-2.7-6-6v-41.5c0-3.3 2.7-6 6-6 3.3 0 6 2.7 6 6v41.5c.1 3.3-2.5 5.9-5.8 6h-.1z"
                                                        fill="#414042"></path>
                                                    <path
                                                        d="m261.9 508.4v-27.4h-80.5v27.4c-.1 19.6 15.8 35.5 35.4 35.6h.1 9.5c19.6-.1 35.5-16 35.5-35.6z"
                                                        fill="#8a5d3b"></path>
                                                    <g>
                                                        <path d="m261.7 360.2.1 44.1" fill="none"></path>
                                                        <path
                                                            d="m261.8 410.3c-3.3 0-6-2.7-6-6v-44.1c0-3.3 2.7-6 6-6 3.3 0 6 2.7 6 6v44.1c0 3.3-2.7 6-6 6z"
                                                            fill="#192a4f"></path>
                                                    </g>
                                                    <path
                                                        d="m309.5 322.1v-26.2c0-6.5-5.2-11.7-11.7-11.7h-24.4c-6.5 0-11.7 5.2-11.7 11.7v26.2z"
                                                        fill="#efcdb1"></path>
                                                </g>
                                                <g>
                                                    <path
                                                        d="m438.6 288.1-99-35.5-16.2 45.1 31.1 11.1-36.3 101.3c-3.9 10.8 1.7 22.7 12.5 26.6l48.3 17.3c26.3 9.4 55.2-4.2 64.6-30.5l25.4-70.8c9.4-26.2-4.2-55.1-30.4-64.6z"
                                                        fill="#89c45e"></path>
                                                    <path
                                                        d="m472.9 351.4c-18.2-5.8-37.7 3.8-44.1 21.8l-3.2 8.9c-6.4 18 2.5 37.8 20.2 45z"
                                                        fill="#efcdb1"></path>
                                                    <path
                                                        d="m421.1 381.5c-.7 0-1.4-.1-2-.4l-39.1-14c-3.1-1.1-4.7-4.6-3.6-7.7 1.1-3.1 4.4-4.7 7.5-3.6h.1l39.1 14c3.1 1 4.9 4.4 3.8 7.6-.8 2.5-3.2 4.2-5.8 4.1z"
                                                        fill="#414042"></path>
                                                    <path
                                                        d="m498.8 360.6-24.5-8.8-1.4-.4-27.1 75.7 1.3.5 24.5 8.8c18.5 6.6 38.8-3 45.4-21.5l3.2-8.9c6.6-18.4-3-38.7-21.4-45.4z"
                                                        fill="#8a5d3b"></path>
                                                    <g>
                                                        <path d="m359.2 310.5 41.5 14.9" fill="none"></path>
                                                        <path
                                                            d="m400.7 331.4-2-.3-41.5-14.9c-3.1-1.1-4.7-4.6-3.6-7.7s4.6-4.7 7.7-3.6l41.5 14.9c3.1 1.1 4.7 4.4 3.6 7.5v.1c-.9 2.4-3.1 4-5.7 4z"
                                                            fill="#75aa4d"></path>
                                                    </g>
                                                    <path
                                                        d="m339.6 252.6-24.7-8.8c-6.1-2.2-12.8 1-15 7v.1l-8.2 22.9c-2.2 6.1 1 12.8 7 15h.1l24.6 8.9z"
                                                        fill="#efcdb1"></path>
                                                </g>
                                                <g>
                                                    <path
                                                        d="m351.7 127.3-62.2 84.8 38.6 28.3 19.5-26.6 86.7 63.6c9.3 6.8 22.3 4.8 29.1-4.5l30.4-41.4c16.5-22.5 11.6-54.1-10.9-70.6l-60.7-44.5c-22.5-16.4-54-11.5-70.5 10.9z"
                                                        fill="#fdc00f"></path>
                                                    <path
                                                        d="m422.1 112.3c-10.7 15.8-7 37.2 8.4 48.5l7.6 5.6c15.4 11.2 36.9 8.4 48.8-6.5z"
                                                        fill="#efcdb1"></path>
                                                    <path
                                                        d="m405.9 208.3c-1.3 0-2.5-.4-3.5-1.1-2.7-2-3.3-5.7-1.3-8.4l24.5-33.5c2-2.7 5.7-3.3 8.4-1.3s3.3 5.7 1.3 8.4l-24.6 33.5c-1.1 1.5-2.9 2.4-4.8 2.4z"
                                                        fill="#414042"></path>
                                                    <path
                                                        d="m438.2 90.2-15.4 21-.7 1.1 64.8 47.6.9-1.1 15.4-21.1c11.6-15.8 8.1-38-7.7-49.6l-7.6-5.6c-15.8-11.6-38-8.2-49.6 7.6-.1 0-.1.1-.1.1z"
                                                        fill="#8a5d3b"></path>
                                                    <g>
                                                        <path d="m350.6 209.7 26.1-35.5" fill="none"></path>
                                                        <path
                                                            d="m350.6 215.7c-1.3 0-2.5-.4-3.6-1.1-2.7-2-3.2-5.7-1.2-8.4l26-35.6c2-2.7 5.7-3.3 8.4-1.3 2.7 2 3.3 5.7 1.3 8.4l-26.1 35.6c-1.1 1.5-2.9 2.4-4.8 2.4z"
                                                            fill="#e5a60a"></path>
                                                    </g>
                                                    <path
                                                        d="m289.5 212.1-15.5 21.1c-3.8 5.2-2.7 12.5 2.5 16.4l19.7 14.4c5.2 3.8 12.5 2.7 16.4-2.5l15.5-21.1z"
                                                        fill="#efcdb1"></path>
                                                </g>
                                                <g>
                                                    <path
                                                        d="m145.4 342.9 97.6-39.2-17.8-44.4-30.7 12.3-40.1-99.8c-4.2-10.6-16.2-15.9-26.9-11.7 0 0-.1 0-.1.1l-47.7 19.2c-25.8 10.4-38.3 39.8-28 65.6l28.1 69.8c10.3 25.9 39.6 38.5 65.5 28.1z"
                                                        fill="#02648e"></path>
                                                    <path
                                                        d="m77.7 318.5c17.4-7.8 25.6-28 18.5-45.7l-3.6-8.8c-7.1-17.7-26.9-26.6-44.8-20.2z"
                                                        fill="#efcdb1"></path>
                                                    <path
                                                        d="m100.4 272c-2.4 0-4.6-1.5-5.5-3.8-1.2-3.1.2-6.6 3.3-7.8l38.5-15.5c3.1-1.2 6.6.3 7.9 3.4 1.2 3.1-.3 6.6-3.4 7.8l-38.5 15.5c-.7.3-1.5.4-2.3.4z"
                                                        fill="#414042"></path>
                                                    <path
                                                        d="m52.3 328.7 24.2-9.7 1.2-.5-29.9-74.7-1.4.5-24.1 9.7c-18.2 7.3-27 28-19.7 46.2l3.5 8.8c7.3 18.2 28 27 46.2 19.7z"
                                                        fill="#8a5d3b"></path>
                                                    <g>
                                                        <path d="m189.9 273.5-41 16.4" fill="none"></path>
                                                        <path
                                                            d="m149 295.9c-3.3.1-6.1-2.5-6.1-5.8-.1-2.5 1.5-4.8 3.8-5.8l40.9-16.4c3.1-1.2 6.6.2 7.8 3.3 1.3 3-.1 6.5-3.1 7.7-.1 0-.1 0-.2.1l-40.9 16.5c-.7.3-1.4.4-2.2.4z"
                                                            fill="#345493"></path>
                                                    </g>
                                                    <path
                                                        d="m243 303.7 24.3-9.8c6-2.4 8.9-9.2 6.5-15.2l-9.1-22.7c-2.4-6-9.2-8.9-15.2-6.5l-24.3 9.8z"
                                                        fill="#efcdb1"></path>
                                                </g>
                                                <g>
                                                    <path
                                                        d="m162.7 154.5 58.3 87.5 39.8-26.5-18.3-27.4 89.6-59.6c9.5-6.4 12.1-19.3 5.7-28.9l-28.4-42.7c-15.5-23.2-46.8-29.5-70-14.1l-62.6 41.7c-23.2 15.4-29.5 46.8-14.1 70z"
                                                        fill="#be1e2d"></path>
                                                    <path
                                                        d="m172.8 83.3c11.2 15.4 32.5 19.3 48.4 8.7l7.9-5.2c15.9-10.5 20.7-31.8 10.7-48.1z"
                                                        fill="#efcdb1"></path>
                                                    <path
                                                        d="m251.8 135.4c-2 0-3.9-1-5-2.7l-23-34.6c-2-2.7-1.4-6.4 1.2-8.4 2.7-2 6.4-1.4 8.4 1.2.1.2.3.4.4.6l23 34.5c1.8 2.8 1.1 6.5-1.7 8.4-1 .6-2.1 1-3.3 1z"
                                                        fill="#414042"></path>
                                                    <path
                                                        d="m157.6 60.4 14.4 21.7.8 1.2 67-44.6-.8-1.2-14.4-21.7c-10.9-16.3-33-20.7-49.3-9.8l-7.8 5.2c-16.3 10.8-20.8 32.7-10 49.1 0 0 .1.1.1.1z"
                                                        fill="#8a5d3b"></path>
                                                    <g>
                                                        <path d="m239.7 183.9-24.4-36.7" fill="none"></path>
                                                        <path
                                                            d="m239.7 189.9c-2 0-3.9-1-5-2.7l-24.4-36.7c-1.9-2.8-1.1-6.5 1.7-8.3 2.8-1.9 6.5-1.1 8.3 1.6l24.4 36.7c1.8 2.7 1.1 6.4-1.5 8.2-.1 0-.1.1-.2.1-1 .7-2.1 1.1-3.3 1.1z"
                                                            fill="#aa1729"></path>
                                                    </g>
                                                    <path
                                                        d="m221 242 14.5 21.8c3.5 5.4 10.7 6.9 16 3.4.1 0 .1-.1.2-.1l20.4-13.5c5.4-3.6 6.8-10.9 3.2-16.3l-14.5-21.8z"
                                                        fill="#efcdb1"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Total Teams</span>
                                        <h2 class="f-w-600">{{ $teams ?? 0 }}</h2>
                                    </div>
                                </li>
                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-light">
                                        <svg id="fi_3528173" height="512" viewBox="0 0 512 512" width="512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m288 440-48-176-72 176-40 8 50.512-202.0482a81.69206 81.69206 0 0 1 21.488-37.9518h72l56 224z"
                                                fill="#8098ab"></path>
                                            <circle cx="312" cy="400" fill="#ffc431" r="72"></circle>
                                            <path
                                                d="m430.11148 384a28.94424 28.94424 0 0 0 25.88852-16l-6.01385-6.01385a55.73275 55.73275 0 0 1 -12.33755-60.10764 32.87582 32.87582 0 0 0 2.3514-12.20981 32.87581 32.87581 0 0 0 -24.90226-31.89422 12.92171 12.92171 0 0 0 -12.271 3.39887l-2.82674 2.82665-32 24v64a32 32 0 0 0 32 32z"
                                                fill="#c47220"></path>
                                            <path
                                                d="m408 184-22.37988 20.12012-22.16016-9.5-28.86987-12.37012a32.10689 32.10689 0 0 1 -18.44019-21.6499l-3.22-12.89014a24.00431 24.00431 0 0 1 .38013 4.29 25.32679 25.32679 0 0 1 -17.31003 24.00004l-24 32h-72v-50.66992l22.67993-37.79a31.99727 31.99727 0 0 1 27.44019-15.54008h59.75976a31.99727 31.99727 0 0 1 27.44019 15.54l14.67993 24.46 38.16992 27.26z"
                                                fill="#ffceb6"></path>
                                            <path
                                                d="m390.16992 171.26a47.7783 47.7783 0 0 0 -20.40992 15.27l-6.3 8.09009 22.16016 9.5 22.37984-20.12009z"
                                                fill="#ffbfa1"></path>
                                            <path
                                                d="m352 144-29.3501 29.3501a31.93558 31.93558 0 0 1 -6.5-12.75l-3.22-12.89014a24.00431 24.00431 0 0 1 .38013 4.29 25.32679 25.32679 0 0 1 -17.31003 24.00004l-24 32h-72v-50.66992l22.67993-37.79a31.99727 31.99727 0 0 1 27.44019-15.54008h59.75976a31.99727 31.99727 0 0 1 27.44019 15.54z"
                                                fill="#02c26a"></path>
                                            <path d="m168 440 24 16v16h-64v-24z" fill="#d1e4ff"></path>
                                            <path d="m296 80v36a12 12 0 0 1 -24 0v-36z" fill="#ffceb6"></path>
                                            <path d="m296 80v32a15.99564 15.99564 0 0 1 -16-16v-16z" fill="#ffbfa1"></path>
                                            <circle cx="272" cy="64" fill="#b66514" r="24"></circle>
                                            <path d="m272 80v-16a16 16 0 0 1 16-16 16 16 0 0 1 16 16v16z" fill="#c47220">
                                            </path>
                                            <path
                                                d="m488 208h-16l5.62988 11.27a7.34306 7.34306 0 0 1 -10.63988 9.38991l-18.99-12.65991h-40l-32 48v48l18.8501 43.08984 37.1499 84.91016 26.53 13.27a9.88782 9.88782 0 0 1 -4.42014 18.73h-38.10986l-52.07007-98.35986-19.92993-37.64014a24.81946 24.81946 0 0 1 -28.6499-4.6499l-3.3501-3.3501-24 8-16-64 64-16 27.31006-35.12012 19.08008-24.52978a32.01468 32.01468 0 0 1 25.25976-12.3501h64.3501a15.99548 15.99548 0 0 1 16 16z"
                                                fill="#ffceb6"></path>
                                            <path d="m64 424-24 48h-16v-72l9.818-6.182z" fill="#e0edff"></path>
                                            <path
                                                d="m88 440 157.54768-68.499a97.96884 97.96884 0 0 0 42.45232-35.501l-16-64-2.67013-.66753a70.82437 70.82437 0 0 0 -54.91363 8.77583l-180.59806 113.70988 30.18182 30.18182 5.17647-2.82353z"
                                                fill="#548aff"></path>
                                            <path
                                                d="m394.8501 355.08984-30.92017 18.5503-19.92993-37.64014a24.81946 24.81946 0 0 1 -28.6499-4.6499l-3.3501-3.3501-24 8-16-64 64-16 27.31006-35.12012 28.68994 19.12012-16 24v48z"
                                                fill="#91c0ff"></path>
                                            <path
                                                d="m280 64a27.31368 27.31368 0 0 0 19.31369 8h4.68631v16a16 16 0 0 1 -16 16 16 16 0 0 1 -16-16v-16z"
                                                fill="#ffceb6"></path>
                                            <path
                                                d="m238.72 175.04-6.72 8.96 16 64 10.53375 5.26688a9.88853 9.88853 0 0 1 5.46625 8.84457 9.88854 9.88854 0 0 1 -9.88853 9.88855h-6.11147l8 16-10.03336 3.34445a16 16 0 0 1 -19.766-8.87622l-35.7555-83.4295a32 32 0 0 1 1.97261-29.06886l12.27137-20.453z"
                                                fill="#ffceb6"></path>
                                            <rect fill="#00b55b" height="16" rx="8"
                                                transform="matrix(.6 -.8 .8 .6 -31.867 263.31)" width="28.8" x="232.96"
                                                y="155.52"></rect>
                                            <path
                                                d="m385.30005 292.8999-21.30005 7.1001a12.64911 12.64911 0 0 1 -8-24l21.02-7.00977 1.04 3.00977z"
                                                fill="#ffceb6"></path>
                                            <path d="m88 440-18.824-18.824-5.176 2.824-24 48h24z" fill="#d1e4ff">
                                            </path>
                                            <path
                                                d="m59.76063 367.99965h184.47874a8.00034 8.00034 0 0 1 8.00034 8.00035 8.00035 8.00035 0 0 1 -8.00035 8.00035h-184.47873a8.00034 8.00034 0 0 1 -8.00034-8.00035 8.00035 8.00035 0 0 1 8.00035-8.00035z"
                                                fill="#4976f2" transform="matrix(.878 -.479 .479 .878 -161.491 118.7)">
                                            </path>
                                            <path
                                                d="m385.30005 292.8999-21.30005 7.1001a12.73118 12.73118 0 0 1 -4 .6499v-12.6499a15.99564 15.99564 0 0 1 16-16h2.06006z"
                                                fill="#ffbfa1"></path>
                                            <path d="m392 296h-8a16 16 0 0 1 -16-16 16 16 0 0 1 16-16h16l8 16z"
                                                fill="#ffceb6"></path>
                                            <circle cx="312" cy="400" fill="#ffb401" r="32"></circle>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Total Therapist</span>
                                        <h2 class="f-w-600">{{ $therapist ?? 0 }}</h2>
                                    </div>
                                </li>
                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-danger-light">
                                        <svg version="1.1" id="fi_489405" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 488.928 488.928"
                                            style="enable-background:new 0 0 488.928 488.928;" xml:space="preserve">
                                            <path style="fill:#EAEAEA;"
                                                d="M474.528,360.816l-64-26.48v-45.52v-80v-32v-98.48l-168-69.52l64,26.48v141.52v32v80v2.48l-64-26.48
                                                                    v-256l-240,80l7.92,245.624l-7.92,2.376v144h480v-120l-8-3.2V360.816z M26.528,120.816l144-48v96l-144,48V120.816z M10.528,256.816
                                                                    l184-56v80l-61.336,18.664l-10.664,3.248l-32,9.736l-27.432,8.352l-52.568,16V256.816z M362.528,353.56v47.256l-168,72
                                                                    l-83.424-39.896l83.424,39.896v-48l-52.56-25.136l163.192-71.448l57.368,24.584l-0.832,0.36L362.528,353.56z">
                                            </path>
                                            <g>
                                                <polygon style="fill:#A9CB73;"
                                                    points="42.528,327.08 42.528,288.816 90.528,272.816 90.528,312.472 122.528,302.728
                                                            122.528,264.816 170.528,248.816 170.528,288.12 133.192,299.48 194.528,280.816 194.528,200.816 10.528,256.816 10.528,336.816
                                                            63.096,320.816 	">
                                                </polygon>
                                                <polygon style="fill:#A9CB73;"
                                                    points="305.16,328.232 141.968,399.68 194.528,424.816 194.528,472.816 362.528,400.816
                                                            362.528,353.56 361.696,353.176 362.528,352.816 	">
                                                </polygon>
                                            </g>
                                            <polygon style="fill:#F4CD57;"
                                                points="170.528,72.816 26.528,120.816 26.528,216.816 170.528,168.816 ">
                                            </polygon>
                                            <g>
                                                <polygon style="fill:#A9CB73;"
                                                    points="306.528,291.296 306.528,288.816 306.528,208.816 306.528,176.816 306.528,35.296
                                                            242.528,8.816 242.528,264.816 	">
                                                </polygon>
                                                <polygon style="fill:#A9CB73;"
                                                    points="410.528,208.816 410.528,288.816 410.528,334.336 474.528,360.816 474.528,357.616
                                                            474.528,240.816 474.528,104.816 410.528,78.336 410.528,176.816 	">
                                                </polygon>
                                            </g>
                                            <g>
                                                <polygon style="fill:#F4CD57;"
                                                    points="90.528,272.816 42.528,288.816 42.528,327.08 63.096,320.816 90.528,312.472 	">
                                                </polygon>
                                                <polygon style="fill:#F4CD57;"
                                                    points="170.528,248.816 122.528,264.816 122.528,302.728 133.192,299.48 170.528,288.12 	">
                                                </polygon>
                                            </g>
                                            <g>
                                                <path style="fill:#2D2D2D;" d="M484.312,401.568l-115.8-54.04c-0.16-0.184-0.36-0.336-0.544-0.504c-0.2-0.184-0.4-0.36-0.616-0.528
                                                                        c-0.144-0.112-0.264-0.256-0.416-0.36c-0.264-0.176-0.552-0.272-0.832-0.408c-0.152-0.08-0.272-0.192-0.424-0.264l-57.368-24.584
                                                                        l-91.288-39.128l25.208-8.4l61.24,25.344h0.008l167.992,69.512c0.976,0.408,2.016,0.608,3.056,0.608
                                                                        c1.56,0,3.112-0.456,4.448-1.344c2.216-1.488,3.552-3.984,3.552-6.656v-256c0-3.24-1.952-6.16-4.936-7.392l-64-26.488h-0.008
                                                                        L245.592,1.424C245,1.176,244.384,1.016,243.76,0.92c-0.016,0-0.024-0.008-0.04-0.008c-1.2-0.176-2.416-0.056-3.568,0.304
                                                                        c-0.048,0.016-0.104,0-0.152,0.016l-240,80l5.064,15.176l229.464-76.496v239.136l-32,10.664v-68.896c0-2.536-1.2-4.92-3.232-6.432
                                                                        c-2.04-1.504-4.672-1.968-7.096-1.224l-184,56c-3.368,1.024-5.672,4.136-5.672,7.656v80v48c0,3.08,1.768,5.888,4.544,7.216
                                                                        l85.104,40.704l-36.96,16.8c-2.84,1.28-4.664,4.104-4.688,7.216s1.76,5.96,4.576,7.296l48.04,22.76l6.84-14.464L77.52,456.968
                                                                        l33.488-15.216l80.056,38.288c0.232,0.112,0.48,0.152,0.712,0.232c0.264,0.096,0.52,0.192,0.792,0.264
                                                                        c0.464,0.12,0.936,0.176,1.408,0.208c0.192,0.008,0.368,0.072,0.552,0.072c0.072,0,0.136-0.024,0.2-0.032
                                                                        c0.496-0.016,0.976-0.104,1.456-0.208c0.208-0.048,0.424-0.056,0.632-0.12c0.208-0.064,0.408-0.168,0.616-0.248
                                                                        c0.08-0.032,0.16-0.016,0.24-0.048l168-72c2.952-1.248,4.856-4.144,4.856-7.344v-34.688l91.272,42.6l-142.584,64.808l6.624,14.56
                                                                        l158.4-72c2.84-1.288,4.672-4.12,4.688-7.24S487.136,402.888,484.312,401.568z M82.528,306.544l-32,9.736v-21.696l32-10.664
                                                                        V306.544z M162.528,282.192l-13.336,4.056l-18.664,5.688v-21.352l32-10.664V282.192z M44.848,334.728
                                                                        C44.856,334.728,44.856,334.728,44.848,334.728l48.008-14.608l0,0l20.448-6.224l11.552-3.512h0.008l48-14.608l0,0l21.2-6.456
                                                                        l90.976,38.992l-142.912,62.576L32.544,338.472L44.848,334.728z M194.712,416.032L161.184,400l144.008-63.048l37.024,15.864
                                                                        L194.712,416.032z M466.528,110.16v238.68l-48-19.864v-40.16v-80v-32V90.304L466.528,110.16z M362.528,266.568l-16,4v-63.504l16-4
                                                                        V266.568z M314.528,215.064l16-4v63.504l-16,4V215.064z M378.528,204.632l12,4.8l12,4.8V277l-24-9.6V204.632z M402.528,197l-12-4.8
                                                                        l-12-4.8v-14.768l24,9.6V197z M362.528,186.568l-48,12v-15.504l48-12V186.568z M369.96,281.208l32.568,13.024v28.128
                                                                        l-74.272-30.736L369.96,281.208z M402.528,165l-24-9.6v-26.584h-16v25.752l-48,12V47.264l88,36.416V165z M298.528,40.648v136.168
                                                                        v32v70.512l-48-19.864V20.784L298.528,40.648z M18.528,262.744l168-51.128v63.28l-8,2.432v-28.512c0-2.568-1.232-4.992-3.32-6.488
                                                                        c-2.104-1.512-4.784-1.912-7.208-1.104l-48,16c-3.272,1.096-5.472,4.144-5.472,7.592V296.8l-16,4.872v-28.856
                                                                        c0-2.568-1.232-4.984-3.32-6.488c-2.096-1.504-4.776-1.912-7.208-1.104l-48,16c-3.272,1.096-5.472,4.144-5.472,7.592v32.336
                                                                        l-16,4.864V262.744z M18.528,349.512l168,80.344v30.264l-71.968-34.424h-0.008l-96.024-45.92V349.512z M354.528,395.544
                                                                        l-152,65.144v-30.592l152-65.144V395.544z"></path>
                                                <path style="fill:#2D2D2D;" d="M26.528,224.816c0.848,0,1.704-0.136,2.528-0.408l144-48c3.272-1.096,5.472-4.144,5.472-7.592v-96
                                                                        c0-2.568-1.232-4.984-3.32-6.488c-2.104-1.504-4.784-1.92-7.208-1.104l-144,48c-3.272,1.096-5.472,4.144-5.472,7.592v96
                                                                        c0,2.568,1.232,4.984,3.32,6.488C23.232,224.304,24.872,224.816,26.528,224.816z M34.528,126.584l128-42.664v79.136l-128,42.664
                                                                        V126.584z"></path>
                                                <path style="fill:#2D2D2D;"
                                                    d="M104.36,143.664l-19.304-6.44c-2.344-0.768-4.912-0.432-6.968,0.936l-24,16l8.872,13.312
                                                                        l20.744-13.832l20.288,6.76c2.872,0.96,6.048,0.2,8.184-1.936l32-32l-11.312-11.312L104.36,143.664z">
                                                </path>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Total Rooms</span>
                                        <h2 class="f-w-600">{{ $rooms ?? 0 }}</h2>
                                    </div>
                                </li>
                            </ul>
                            <ul class="product-costing">
                                <li class="product-cost">
                                    <div class="product-icon bg-danger-light">
                                        <svg id="fi_6543820" enable-background="new 0 0 73 73" height="512"
                                            viewBox="0 0 73 73" width="512" xmlns="http://www.w3.org/2000/svg">
                                            <g id="_x36_3">
                                                <g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <g>
                                                                                                                    <g>
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <g>
                                                                                                                                    <g>
                                                                                                                                        <path
                                                                                                                                            d="m27.957 23.62h18.676v24.867h-18.676z"
                                                                                                                                            fill="#2d77fc">
                                                                                                                                        </path>
                                                                                                                                    </g>
                                                                                                                                </g>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                </g>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m43.2683334 23.6064739-4.7931518 7.3449536-1.1823464 1.8117866-1.1823234-1.8117866-4.7888928-7.3449536z"
                                                                                                                    fill="#f7f8f8">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m38.4751816 30.9514275-1.1823464 1.8117866-1.1823234-1.8117866.3870125-3.7681599.0468025-.4720764h1.4970398l.0425491.4082718z"
                                                                                                                    fill="#f24e66">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m38.8000412 26.298996-.8999672 1.0275784c-.3391838.3872776-.9418068.3872757-1.2809868-.0000019l-.8999634-1.0275784c-.4820633-.5504246-.0911827-1.4123611.6404953-1.4123611h1.7999306c.7316818-.0000001 1.1225624.8619384.6404915 1.412363z"
                                                                                                                    fill="#f24e66">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                </g>
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m39.9594803 19.7447605v3.8702278l-2.6623879 1.2716446-2.6708755-1.2716446v-3.8702278z"
                                                                                                                    fill="#f9b29c">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m39.9594803 19.7447605v2.0371819c-.7485352.4210434-1.6076241.6592102-2.5220337.6592102-1.037735 0-2.0031738-.3062038-2.8112297-.8335724v-1.8628197z"
                                                                                                                    fill="#ed8768">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m41.530941 23.618185-2.0883865 2.8188229-2.1471787-1.5491447 2.6668511-2.3236847 1.5295181 1.0490989z"
                                                                                                                    fill="#e6e8e8">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m33.0586586 23.618185 2.0883827 2.8188229 2.1471825-1.5491447-2.6668549-2.3236847-1.5295143 1.0490989z"
                                                                                                                    fill="#e6e8e8">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m55.481102 25.1571503-8.8477173 10.7937317v-12.3324967l3.5921631-3.2091751.7668915-9.0919008 4.7577515-.1699934 1.0056496 10.0347519c.0829619 1.4406128-.3695909 2.8586673-1.2747384 3.9750824z"
                                                                        fill="#2d77fc"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m47.6953926 34.6543083-1.0620079 1.2965737v-9.2399579z"
                                                                        fill="#125ac4"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m56.239933 8.2581615-.4721985 3.0579796h-4.7746201l-1.2099533-2.1407623c-.1993713-.3527441-.0798531-.8001652.2688599-1.0065041v-.000001c.3562317-.2107863.8160057-.0903444 1.02314.2680216l.3781013.65415.0619202-1.106288c.0256424-1.2439189 1.0095711-2.2558436 2.2522812-2.316361h.0000076c1.4409866-.0701726 2.6093063 1.1535718 2.4724617 2.5897652z"
                                                                        fill="#f9b29c"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m19.1090069 25.1571503 8.8477173 10.7937317v-12.3324967l-3.5921612-3.2091751-.7668915-9.0919008-4.7577515-.1699934-1.0056534 10.0347519c-.0829601 1.4406128.3695908 2.8586673 1.2747403 3.9750824z"
                                                                            fill="#2d77fc"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m26.8947182 34.6543083 1.062006 1.2965737v-9.2399579z"
                                                                            fill="#125ac4"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m18.3501759 8.2581615.4722004 3.0579796h4.7746201l1.2099514-2.1407623c.1993713-.3527441.079855-.8001652-.268858-1.0065041l-.0000019-.000001c-.3562298-.2107863-.8160057-.0903444-1.02314.2680216l-.3780994.65415-.0619221-1.106288c-.0256405-1.2439189-1.0095711-2.2558436-2.2522812-2.316361h-.0000057c-1.4409905-.0701726-2.6093064 1.1535718-2.4724636 2.5897652z"
                                                                            fill="#f9b29c"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m36.5463982 67.7065353.7887077-14.3831749.7311859 14.3831749h8.5496597l-.0650482-19.219532h-18.5065765l-.0690365 19.219532z"
                                                                                fill="#29275c"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <ellipse cx="32.344" cy="15.371" fill="#f9b29c"
                                                                        rx="1.258" ry="1.468"></ellipse>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m31.9109535 15.8475552c-.1509953-.1336193-.2341442-.3028145-.2341442-.4765606 0-.174159.083149-.3433552.2337303-.4765596.0438499-.0388861.047987-.1054888.0095139-.1493387-.0388851-.0438509-.1063156-.047987-.1493378-.0095148-.1973267.174159-.3057117.3996153-.3057117.6354132 0 .2353849.1083851.4608402.3052979.6354141.1043204.0915469.2457542-.0656472.1406516-.1588536z"
                                                                        fill="#ed8768"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <ellipse cx="42.329" cy="15.371" fill="#f9b29c"
                                                                        rx="1.258" ry="1.468"></ellipse>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m42.7621078 15.8475552c.1509933-.1336193.2341423-.3028145.2341423-.4765606 0-.174159-.083149-.3433552-.2337265-.4765596-.0438499-.0388861-.0479889-.1054888-.0095177-.1493387.038887-.0438509.1063194-.047987.1493416-.0095148.1973228.174159.3057098.3996153.3057098.6354132 0 .2353849-.108387.4608402-.3052979.6354141-.1057928.0928401-.2451552-.0661813-.1406516-.1588536z"
                                                                        fill="#ed8768"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m32.1749382 13.7702084v2.7028446c0 2.8732738 2.3304863 5.1983681 5.1983681 5.1983681 2.8731766 0 5.1983337-2.3250942 5.1983337-5.1983681v-2.7028446c0-2.8732738-2.3251572-5.1983671-5.1983337-5.1983671-2.8737717-.0000001-5.1983681 2.3248805-5.1983681 5.1983671z"
                                                                        fill="#f9b29c"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m38.9559402 15.0215158c0 .3608809.1980476.6513577.4444962.6513577.2464523 0 .4488792-.2904768.4488792-.6513577 0-.3608799-.2024269-.655735-.4488792-.655735-.2464485 0-.4444962.2948551-.4444962.655735z"
                                                                        fill="#15144f"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m34.8981819 15.0215158c0 .3608809.1980476.6513577.4444962.6513577.2464523 0 .4488792-.2904768.4488792-.6513577 0-.3608799-.2024269-.655735-.4488792-.655735-.2464485 0-.4444962.2948551-.4444962.655735z"
                                                                        fill="#15144f"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m39.1875076 17.82691c.001133.0264816.007885.0513439.007885.0780907 0 1.0063229-.815773 1.8220959-1.8220596 1.8220959-1.006321 0-1.822094-.815773-1.822094-1.8220959 0-.0267467.006752-.051609.007885-.0780907z"
                                                                        fill="#fff"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m32.0984077 14.7091265.075695.0623293s.6276665.0712137.6276665 0c0-.0712404.1647072-1.1974831.1647072-1.1974831s1.1218109-1.5669746.3205299-3.0048351c.1424255.0756693 3.4989548 1.8474007 7.8837776.1201744 0 0 .6098671.5030336.4184532 1.8741369-.0979233.6721973.2047844 1.6471004.4941216 2.6665087h.4896927l.3962021-1.1262426s2.4038506-2.127882.2403755-3.9307775c.0311661-.0890379.0578728-.1736193.0756683-.2582006.0178261-.0623293.0311661-.1202021.0400772-.1780748.0088844-.0311375.01334-.0623026.0177956-.0934668.1825333-1.0951052 1.1704063-2.166491.3379593-2.8030677 0 0-.0044556-.004456-.0089111-.004456-2.6486855-2.0210199-10.9149551-2.5833669-11.5738106 1.6100397 0 0-1.5136318.1519585-1.8207932 1.5141487-.3160476 1.362191 1.8207932 4.7492665 1.8207932 4.7492665z"
                                                                        fill="#15144f"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m41.0250359 41.0250587h-.0000039c-1.9245377 0-3.5573692 1.4126091-3.8342552 3.3171272l-2.8060913 19.3013687 5.4360809.2095604 6.4676323-18.1564598z"
                                                                                                                    fill="#03c88b">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m41.0250359 47.7305565-2.3296547 16.0357399 1.1268959.0901298 3.8247566-10.3979988z"
                                                                                                                    fill="#02b07e">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <g>
                                                                                                                    <g>
                                                                                                                        <g>
                                                                                                                            <g>
                                                                                                                                <g>
                                                                                                                                    <g>
                                                                                                                                        <path
                                                                                                                                            d="m41.025 41.025h17.342v24.867h-17.342z"
                                                                                                                                            fill="#03c88b">
                                                                                                                                        </path>
                                                                                                                                    </g>
                                                                                                                                </g>
                                                                                                                            </g>
                                                                                                                        </g>
                                                                                                                    </g>
                                                                                                                </g>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                </g>
                                                                                                <g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m52.3608742 37.149559v3.8702278l-2.6623879 1.2716484-2.6708755-1.2716484v-3.8702278z"
                                                                                                                    fill="#f9b29c">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m52.3608742 37.149559v2.0371819c-.7485352.4210472-1.6076241.659214-2.5220299.659214-1.037735 0-2.0031776-.3062057-2.8112335-.8335724v-1.8628235z"
                                                                                                                    fill="#ed8768">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m53.9323349 41.0229836-2.0883827 2.8188247-2.1471825-1.5491447 2.6668549-2.3236847 1.5295143 1.049099z"
                                                                                                                    fill="#02b07e">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                    <g>
                                                                                                        <g>
                                                                                                            <g>
                                                                                                                <path
                                                                                                                    d="m45.4600525 41.0229836 2.0883865 2.8188247 2.1471787-1.5491447-2.6668511-2.3236847-1.5295181 1.049099z"
                                                                                                                    fill="#02b07e">
                                                                                                                </path>
                                                                                                            </g>
                                                                                                        </g>
                                                                                                    </g>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <ellipse cx="54.89"
                                                                                                cy="32.855"
                                                                                                fill="#f9b29c"
                                                                                                rx="1.264"
                                                                                                ry="1.475">
                                                                                            </ellipse>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m55.3252373 33.3335953c.1517067-.1342506.2352524-.3042488.2352524-.478817 0-.174984-.0835457-.3449783-.2348366-.4788132-.0440598-.0390701-.048214-.1059914-.0095596-.1500473.0390701-.0440598.1068192-.048214.1500435-.0095596.1982613.174984.3071594.4015083.3071594.6384201 0 .2364998-.1088982.4630241-.3067436.6384239-.1062928.0932808-.2463151-.066494-.1413155-.1596069z"
                                                                                                fill="#ed8768">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <ellipse cx="44.858"
                                                                                                cy="32.855"
                                                                                                fill="#f9b29c"
                                                                                                rx="1.264"
                                                                                                ry="1.475">
                                                                                            </ellipse>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m44.4318542 33.4840584c.0386543-.0440598.0349121-.111393-.0091438-.1504631-.1517105-.1342506-.2352524-.3042488-.2352524-.478817 0-.174984.0835419-.3449783.2348366-.4788132.0440559-.0390701.048214-.1059914.0095596-.1500473-.0390701-.0440598-.1068192-.048214-.1500473-.0095596-.1982574.174984-.3071556.4015083-.3071556.6384201 0 .2364998.1088982.4630241.3067398.6384239.0432053.0379143.1104203.0356102.1504631-.0091438z"
                                                                                                fill="#ed8768">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m55.0600014 31.2464161v2.7156391c0 2.8868752-2.3415184 5.2229767-5.2229767 5.2229767-2.8867798 0-5.2229462-2.3361015-5.2229462-5.2229767v-2.7156391c0-2.8868771 2.3361664-5.2229786 5.2229462-5.2229786 1.4434052 0 2.7478104.5826225 3.6940498 1.528862.9462052.9462376 1.5289269 2.2506123 1.5289269 3.6941166z"
                                                                                                fill="#f9b29c">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m48.2468987 32.5036469c0 .362587-.1989861.6544418-.4466019.6544418-.2476196 0-.451004-.2918549-.451004-.6544418 0-.3625908.2033844-.6588402.451004-.6588402.2476158 0 .4466019.2962494.4466019.6588402z"
                                                                                                fill="#15144f">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m52.3238678 32.5036469c0 .362587-.1989861.6544418-.4466057.6544418-.2476158 0-.4510002-.2918549-.4510002-.6544418 0-.3625908.2033844-.6588402.4510002-.6588402.2476196 0 .4466057.2962494.4466057.6588402z"
                                                                                                fill="#15144f">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m48.0142326 35.322319c-.0011368.0266113-.0079231.05159-.0079231.0784645 0 1.0110855.8196373 1.830719 1.8306847 1.830719 1.0110893 0 1.8307228-.8196335 1.8307228-1.830719 0-.0268745-.0067863-.0518532-.0079231-.0784645z"
                                                                                                fill="#fff">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <path
                                                                                                d="m55.1354752 32.188652-.0725021.0634422s-.6337395.0725021-.6337395 0c0-.0723953-.1629143-1.2041531-.1629143-1.2041531s-1.1317558-1.57551-.3169785-3.0240288c0 0-3.4298134 1.8999805-7.9296608.1254177 0 0-.6122437.5061169-.4164543 1.8832073.0959816.6750832-.209938 1.6582069-.499733 2.6813221h-.488842l-.3984375-1.1317596s-1.9284134-3.5491257.2444763-5.3599396c0 0-.7695732-2.8973694 2.4717445-3.9295464l.5342712 1.7112312s1.2765427-2.0099773 3.8207893-2.1186218c2.5533104-.1177063 2.0009155 2.200079 2.0009155 2.200079s1.6207161-.7605114 2.2453918.0906277c.6157265.8510303-.3983269 1.7201862-.3983269 1.7201862s.8148918.5885372 1.1226959 1.9557114c.3169826 1.3671724-1.1226956 4.3368245-1.1226956 4.3368245z"
                                                                                                fill="#15144f">
                                                                                            </path>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m67.2155838 42.5619507-8.8477173 10.7937317v-12.3324967l3.5921593-3.2091751.7668915-9.0918999 4.7577553-.1699944 1.0056534 10.0347519c.0829543 1.4406129-.3695985 2.8586694-1.2747422 3.9750825z"
                                                                        fill="#03c88b"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m59.4298706 52.0591087-1.0620041 1.2965737v-9.2399559z"
                                                                        fill="#02b07e"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="m67.974411 25.662962-.4721985 3.0579796h-4.7746201l-1.2099533-2.1407623c-.1993675-.3527431-.0798531-.8001652.2688599-1.0065041h.0000038c.3562279-.2107868.8160019-.0903454 1.02314.2680206l.3780975.65415.061924-1.1062889c.0256386-1.2439175 1.0095673-2.2558422 2.2522812-2.3163605h.0000076c1.4409867-.0701733 2.6093064 1.1535721 2.4724579 2.5897656z"
                                                                        fill="#f9b29c"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m58.2915611 67.7065353-.0061493-1.8147277h-17.1727829l-.0065155 1.8147277z"
                                                                                fill="#393982"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <path
                                                                    d="m39.8556137 66.3373718c-.1000519.0533295-.2134171.0733566-.3201447.0733566-.2267303 0-.4534988-.1067352-.5868912-.3068008l-.3867798-.5802078-.1534195 2.1808243h-5.0418777l1.020401-4.0615349 5.4353752.2134171.3934555 1.7006264c.0733529.3068008-.0800246.6335754-.3601188.7803191z"
                                                                    fill="#f9b29c"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m9.9516487 47.951622c0 1.0629616 14.3934765 1.0629616 14.3934765 0-1.3792419-4.2704773 3.7126465-14.5352135-2.4433079-18.5718002-5.2132473-3.4184628-7.8278542.7102108-7.8278542.7102108s-1.3609066-.8202724-3.5504026 1.0814171c-3.1402164 2.727438-.2878532 8.492548-.2878532 8.492548.4768696 1.8566627-.0370245 6.3949394-.2840586 8.2876243z"
                                                                            fill="#15144f"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <path
                                                                                                    d="m10.644 49.148h13.583v18.558h-13.583z"
                                                                                                    fill="#ff8e2e">
                                                                                                </path>
                                                                                            </g>
                                                                                        </g>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <g>
                                                                                        <path
                                                                                            d="m20.3020821 44.1338692.0414238 5.015995h-5.810196l-.0414228-5.015995z"
                                                                                            fill="#f9b29c"></path>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <path
                                                                                        d="m20.3435059 44.1338692v3.0207939c-2.0573196.0967598-3.9842434-.3954811-5.8101959-1.3799591v-1.6408348z"
                                                                                        fill="#ed8768"></path>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m23.3642197 49.1570854s-.4944019 3.8752518-2.441782 4.5204468c-2.1507149.7125664-3.5267792-1.3818283-3.5267792-1.3818283l4.1499481-3.1448021z"
                                                                                fill="#caf5fe"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m11.506279 49.1570854s.494401 3.8752518 2.441783 4.5204468c2.1507139.7125664 3.5267782-1.3818283 3.5267782-1.3818283l-4.1499472-3.1448021z"
                                                                                fill="#caf5fe"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m21.6912498 49.1509018c-.5282764 1.8616028-2.2452774 3.2264786-4.276701 3.2264786s-3.7421293-1.3648758-4.2704067-3.2264786z"
                                                                                fill="#f9b29c"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <ellipse cx="23.331" cy="39.064"
                                                                                        fill="#f9b29c" rx="1.491"
                                                                                        ry="1.739"></ellipse>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <path
                                                                                        d="m23.8447018 39.6289597c.1788616-.1582832.277359-.3587074.277359-.5645218 0-.2063065-.0984974-.4067307-.2768707-.5645218-.0519428-.0460625-.0568428-.124958-.0112705-.1769028.0460644-.0519447.1259403-.0568428.1769028-.0112686.2337475.2063026.3621368.4733734.3621368.7526932 0 .2788315-.1283894.5459023-.3616467.752697-.1253204.1099739-.2904034-.0783997-.1666107-.1881752z"
                                                                                        fill="#ed8768"></path>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <ellipse cx="11.504" cy="39.064"
                                                                                        fill="#f9b29c" rx="1.491"
                                                                                        ry="1.739"></ellipse>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                        <g>
                                                                            <g>
                                                                                <g>
                                                                                    <path
                                                                                        d="m10.9906912 39.6289597c-.1788626-.1582832-.27736-.3587074-.27736-.5645218 0-.2063065.0984974-.4067307.2768707-.5645218.0519438-.0460625.0568438-.124958.0112705-.1769028-.0460634-.0519447-.1259394-.0568428-.1769028-.0112686-.2337475.2063026-.3621368.4733734-.3621368.7526932 0 .2788315.1283894.5459023.3616467.752697.1247158.1094436.2912998-.0776024.1666117-.1881752z"
                                                                                        fill="#ed8768"></path>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d="m23.5748959 35.6032944v4.7700768c0 3.3992004-2.758194 6.1570053-6.1571999 6.1570053-3.4072266 0-6.1571989-2.7578049-6.1571989-6.1570053v-4.7700768c0-3.4048767 2.7576704-6.1570034 6.1571989-6.1570034 3.3990669 0 6.1571999 2.7575473 6.1571999 6.1570034z"
                                                                                    fill="#f9b29c"></path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d="m15.5420723 38.6504555c0 .4274902-.234602.7715797-.5265427.7715797s-.5317297-.3440895-.5317297-.7715797.239789-.7767677.5317297-.7767677.5265427.3492774.5265427.7767677z"
                                                                                    fill="#15144f"></path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d="m20.348793 38.6504555c0 .4274902-.2346039.7715797-.5265427.7715797-.2919407 0-.5317307-.3440895-.5317307-.7715797s.23979-.7767677.5317307-.7767677c.2919388-.0000001.5265427.3492774.5265427.7767677z"
                                                                                    fill="#15144f"></path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <g>
                                                                                <path
                                                                                    d="m15.2677612 41.9736519c-.0013409.0313721-.0093403.0608215-.0093403.0925064 0 1.1920662.9663448 2.1584091 2.1583652 2.1584091 1.1920643 0 2.1584091-.9663429 2.1584091-2.1584091 0-.0316849-.0079994-.0611343-.0093403-.0925064z"
                                                                                    fill="#fff"></path>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="m23.8636475 35.4573402-.2724171 1.9116096c0 2.0122757-.9539776 3.2228508-.9539776 3.2228508s-.2646236-1.9001236-1.3869247-3.8642502c-1.122303-1.9641266-4.8102016-3.2148247-6.4535313-3.8000526-.3769722-.1362267-.6494246-.3206024-.842021-.5210266-.1601048 2.0602303-2.581255 7.6482544-2.6775532 7.4717064l-.0701036-4.2711486c0-3.4532127 2.6067619-6.3202114 6.1430588-6.3202114 1.6996994 0 3.2389011.689352 4.3533726 1.8038254 1.1144733 1.1142787 2.1600971 2.6669978 2.1600971 4.3666972z"
                                                                                fill="#15144f"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m30.3840008 67.7065353v-12.8336868c0-3.1615791-2.5630074-5.7245445-5.7245464-5.7245445h-.4326572v18.5582314h6.1572036z"
                                                                            fill="#ff8e2e"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path d="m24.433 58.686h.486v9.021h-.486z"
                                                                            fill="#f67112"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="m10.6572437 67.7065353v-18.5582313h-.4326563c-3.1615791 0-5.7245874 2.5629654-5.7245874 5.7245445v12.8336868z"
                                                                            fill="#ff8e2e"></path>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <g>
                                                                    <path d="m9.465 58.686h.486v9.021h-.486z"
                                                                        fill="#f67112"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div><span class="f-w-500 f-14 mb-0">Total Groups</span>
                                        <h2 class="f-w-600">{{ $groups ?? 0 }}</h2>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="col-xxl-8 col-md-12 box-col-12">
                    <div class="card height-equal">
                        <div class="card-header total-revenue card-no-border">
                            <h4>Latest Bookings</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-order table-responsive custom-scrollbar">
                                <table class=" latest-orders w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">ID</th>
                                            <th>Client Name</th>
                                            <th>Type</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($latestBookings as $booking)
                                            <tr>
                                                <td> {{ $booking->id }} </td>
                                                <td> {{ $booking->client_name }} </td>
                                                <td>
                                                    @php
                                                        $types = [
                                                            'school' => 'School',
                                                            'fsp_csp' => 'FSP/CSP',
                                                            'centre_home_community' => 'Centre Home',
                                                        ];
                                                    @endphp

                                                    {{ $types[$booking->booking_form_type] ?? ucfirst($booking->booking_form_type) }}

                                                </td>
                                                <td> {{ $booking->created_at->diffForHumans() }} </td>
                                                <td> <span
                                                        class="badge rounded-pill badge-{{ $booking->status == 'active' ? 'primary' : 'warning' }}">{{ ucwords($booking->status) }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loader = `<div class="text-center p-5"><div class="spinner-border text-primary"></div></div>`;
            document.querySelector("#bookingChart").innerHTML = loader;

            fetch('/booking-chart-data')
                .then(response => response.json())
                .then(data => {
                    var options = {
                        series: [{
                            name: 'Active',
                            data: data.active
                        }, {
                            name: 'Archive',
                            data: data.archive
                        }],
                        chart: {
                            type: 'area',
                            height: 300,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#006666', '#FFAE1A'],
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        fill: {
                            gradient: {
                                opacityFrom: 0.5,
                                opacityTo: 0
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: data.dates,
                            labels: {
                                style: {
                                    colors: '#6c757d'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: val => val
                            }
                        },
                        tooltip: {
                            shared: true
                        }
                    };
                    document.querySelector("#bookingChart").innerHTML = '';
                    var chart = new ApexCharts(document.querySelector("#bookingChart"), options);
                    chart.render();
                })
                .catch(() => {
                    document.querySelector("#bookingChart").innerHTML =
                        '<p class="text-danger text-center">Failed to load chart data.</p>';
                });
        });
    </script>
@endsection
