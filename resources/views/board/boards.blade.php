@extends('base')

@section('css')

  <style>

      html, body, #app {
    max-height: 100vh;
    height: 100vh;
    }
    #header {
    background: rgba(0,0,0,.15);
    overflow: hidden;
    padding: 5px 8px;
    position: relative;
    height: 40px;
    text-align: center;
    margin: 0 0 20px;
    .header-logo {
        background-position: top right;
        background-repeat: no-repeat;
        background-size: 5pc 30px;
        right: 0;
        top: 0;
        height: 30px;
        width: 5pc;
        position: absolute;
        text-align: center;
        bottom: 0;
        display: block;
        left: 50%;
        margin-left: -40px;
        top: 5px;
        text-align: center;
        -webkit-transition: .1s ease;
        transition: .1s ease;
        z-index: 2;
    }
    }
    #boards {
    .board {
        width: 304px;
        padding-left: 5px;
        padding-right: 5px;
        float: left;
        .kanban-wrapper {
            background-color: #E2E4E6;
            border-radius: 5px;
            overflow: hidden;
            .board-title {
                padding: 10px;
                h2 {
                    margin: 0;
                    font-size: 14px;
                    font-weight: 600;
                    color: #272727;
                }
            }
            .cards {
                list-style: none;
                margin: 0;
                padding: 0 10px;
                > div {
                    min-height: 5px;
                    padding: 5px 0;
                }
                .card {
                    overflow: hidden;
                    padding: 8px;
                    background-color: #fff;
                    border-bottom: 1px solid #ccc;
                    border-radius: 3px;
                    cursor: pointer;
                    margin-bottom: 6px;
                    max-width: 300px;
                    min-height: 20px;
                    &:hover {
                        background-color: #edeff0;
                    }
                }
            }
            .add-card {
                color: #838c91;
                display: block;
                flex: 0 0 auto;
                padding: 8px 10px;
                position: relative;
                &[disabled], &[disabled]:hover {
                    cursor: not-allowed;
                    text-decoration: none;
                }
            }
        }
    }
    }

  </style>

@stop

@section('content')
    <boards :boards="boards"></boards>
@stop
