$(document).ready(function() {

	var follow_chart = document.getElementById('follow');
	var follow = echarts.init(follow_chart, 'walden');
	var data_followers = $('#i_followers').val();
	var data_following = $('#i_following').val();

	var follow_option = {
            title: {
                text: 'Your follows',
                right: 'right',
                padding: [5,10]
            },
            tooltip: {},
            legend: {
                data:['followers','following'],
                x: 'left'
            },
            xAxis: { },
            yAxis: {
            	data: ["users"]
            },
            series: [
            {
                name: 'followers',
                type: 'bar',
                data: [data_followers]
            },
            {
                name: 'following',
                type: 'bar',
                data: [data_following]
            }
            ]
        };
    follow.setOption(follow_option);


    var repo_chart = document.getElementById('repo');
	var repo = echarts.init(repo_chart, 'walden');
	var data_public_repos = $('#i_public_repos').val();
	var data_total_private_repos = $('#i_total_private_repos').val();

    var repo_option = {
    	title: {
                text: 'Your repositories',
                right: 'right',
                padding: [5,10]
            },
        tooltip: {
            trigger: 'item',
            formatter: "{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data:['public repos','private repos']
        },
        series: [
            {
                name:'your repos',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[
                    {value:data_public_repos, name:'public repos'},
                    {value:data_total_private_repos, name:'private repos'}
                ]
            }
        ]
    };

    repo.setOption(repo_option);
});