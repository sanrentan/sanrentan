		<p class="titleLabel">ユーザーランキング(<?php echo $ranking_year;?>年)</p>
		<div class="ranking">
			<div id="rankingContent">
				<table class="table">
						<th>順位</th><th>ユーザー</th><th>収支・勝敗</th>
						<?php foreach($rankedUsers as $rank => $rankedUser): ?>
							<tr>
								<td><?php echo $rank + 1 ?></td>
								<td>
									<a href="/other/<?php echo $rankedUser['User']['id'];?>"><?php if(!empty($rankedUser['User']['profile_img'])): ?><img src="/img/profileImg/<?php echo $rankedUser['User']['profile_img'] ; ?>" alt=""><?php else: ?><img src="/img/common/noimage_person.png" alt=""><?php endif ?><br><?php echo $rankedUser['User']['nickname'] ?></a>
								</td>
								<td><?php echo number_format($rankedUser['ExpectationResult']['price']); ?>円<br><?php echo $rankedUser['ExpectationResult']['win'] ?>勝<?php echo $rankedUser['ExpectationResult']['lose'] ?>敗</td>
							</tr>
						<?php endforeach; ?>
				</table>
			</div>
		</div>
