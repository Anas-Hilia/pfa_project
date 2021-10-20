@extends('layouts.app')

@section('template_title')
    {{trans('Statistics')}}
@endsection

@section('head')

    <link href="../../assets/styles.css" rel="stylesheet" />

    <script>
        window.Promise ||
          document.write(
            '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
          )
        window.Promise ||
          document.write(
            '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
          )
        window.Promise ||
          document.write(
            '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
          )
      </script>
  
      
      <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      <script src="https://cdn.jsdelivr.net/npm/vue-apexcharts"></script>
      
  
      <script>
          
        // Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
        // Based on https://gist.github.com/blixt/f17b47c62508be59987b
        var _seed = 42;
        Math.random = function() {
          _seed = _seed * 16807 % 2147483647;
          return (_seed - 1) / 2147483646;
        };
      </script>
  
@endsection


@section('template_title')
    {!! trans('usersmanagement.showing-all-users') !!}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
        .img_icon{

            height:270px;
            width:270px;
        }
        
        #mon-chart{
                width: 1000px;
                height:500px;
            }
        #chart{
            width: 1000px;
            height:900px;
        }
        
       
    
  
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                              @if(Route::currentRouteName()=="statistics_byFormation_charts")
                                {!! trans('Statistics : representation of formation by their branches depending on number of students ') !!}
                              @else
                                @if($id_check == 1)
                                  {!! trans('Statistics : representation of students by formation ') !!}
                                @elseif($id_check==2)
                                  {!! trans('Statistics : representation of students by branche of formation ') !!}
                                @else
                                  @if(Auth::User()->currentUserRole==2)
                                    {!! trans('Statistics : representation of Your students by their status of payment ') !!}
                                  @else
                                    {!! trans('Statistics : representation of students by their status of payment ') !!}
                                  @endif
                                @endif

                              @endif
                              <strong>
                                @if(Auth::User()->currentUserRole==2)
                                  {!! trans('(Total Your Students : ').$total_student.')' !!}
                                @else
                                  {!! trans('(Total Students : ').$total_student.')' !!}
                                @endif
                                
                              </strong>
                            </span>
                            
                            
                        </div>
                    </div>

                    <div class="card-body" >
                      @if(Route::currentRouteName()=="statistics_byFormation_charts")
                        @if($formation->name)
                          <div class="text-center">
                            <strong class="">
                              {{trans('Name of Formation : ')}}
                            </strong>
                            {{$formation->name}}
                          </div>
                        @endif
                        @if($formation->total)
                          <div class="text-center ">
                            <strong class="">
                              {{trans('Number of Students : ')}}
                            </strong>
                            {{$formation->total}}
                          </div>
                        @endif  
                      @endif
                      
                    
                        <div class="col-sm-5 col-6 text-larger">
                          <strong>
                            {{ trans('Bar Chart :') }}
                          </strong>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div id="mon-chart"  ></div>
                        </div>

                        <div class="col-sm-5 col-6 text-larger">
                            <strong>
                              {{ trans('Pie Chart :') }}
                            </strong>
                          </div>

                        <div id="app" class="d-flex justify-content-center col-md-12"  >
                            <div id="chart" > </div>
                        </div>
                      

                         

                        
                          
                      


                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')
    
@endsection

@section('footer_scripts')
    <script>


        var options = {
          series: [
          {
            name: 'Actual',
            data: [
              @if( isset($id_check) && $id_check==3) 
                @foreach ( $statisticTable as $row )

                  {
                      x: {!! json_encode($row['name'], JSON_HEX_TAG) !!}, 
                      y: {!! json_encode($row['nbr_Student'], JSON_HEX_TAG) !!},
                          
                      goals: [
                          {
                              name: 'Expected',
                              value: 60,
                              strokeWidth: 5,
                              strokeColor: '#775DD0'
                          }
                      ]
                  },
                @endforeach
              @else
                @foreach ( $statisticTable as $row )

                  {
                      x: {!! json_encode($row->name, JSON_HEX_TAG) !!},
                      y: {!! json_encode($row->nbr_Student, JSON_HEX_TAG) !!},
                         
                      goals: [
                          {
                              name: 'Expected',
                              value: 60,
                              strokeWidth: 5,
                              strokeColor: '#775DD0'
                          }
                      ]
                  },
                @endforeach
              @endif
              
            ]
          }
        ],
          chart: {
          height: 350,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            horizontal: true,
          }
        },
        colors: ['#00E396'],
        dataLabels: {
          formatter: function(val, opt) {
            const goals =
              opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                .goals
        
            if (goals && goals.length) {
              return `${val} / ${goals[0].value}`
            }
            return val
          }
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          customLegendItems: ['Actual', 'Expected'],
          markers: {
            fillColors: ['#00E396', '#775DD0']
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Catégories', 'Produits'],
      @if(isset($id_check) && $id_check==3)
        @foreach ($statisticTable as $row) // On parcourt les catégories
          [ {!! json_encode($row['name'], JSON_HEX_TAG) !!}, {!! json_encode($row['nbr_Student'], JSON_HEX_TAG) !!} ], 
        @endforeach
      @else
        @foreach ($statisticTable as $row) // On parcourt les catégories
          [ {!! json_encode($row->name, JSON_HEX_TAG) !!}, {!! json_encode($row->nbr_Student, JSON_HEX_TAG) !!} ], 
        @endforeach
      @endif
    ]);

    var options = {
      title:
              @if(Route::currentRouteName()=="statistics_byFormation_charts")
                {!! json_encode(trans('Proportion of formation by their branches depending on number of students ') , JSON_HEX_TAG) !!},
              @else  
                @if($id_check == 1) // Le titre
                  {!! json_encode(trans('Proportion of students by branche of formation '), JSON_HEX_TAG) !!}, 
                @elseif($id_check==2)
                  {!! json_encode(trans('Proportion of students by formation '), JSON_HEX_TAG) !!},
                @else
                  {!! json_encode(trans('Proportion of students by their status of payment '), JSON_HEX_TAG) !!},
                @endif
              @endif
              
      is3D : true // En 3D
    };

    // On crée le chart en indiquant l'élément où le placer "#mon-chart"
    var chart = new google.visualization.PieChart(document.getElementById('mon-chart'));

    // On désine le chart avec les données et les options
    chart.draw(data, options);
  }
</script>

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-users')
    @endif
@endsection
