package com.baidu.ueditor.upload;

import com.baidu.ueditor.PathFormat;
import com.baidu.ueditor.define.AppInfo;
import com.baidu.ueditor.define.BaseState;
import com.baidu.ueditor.define.FileType;
import com.baidu.ueditor.define.State;

import java.util.Map;

import org.apache.commons.codec.binary.Base64;

public final class Base64Uploader {

	public static State save(String content, Map<String, Object> conf) {
		
		byte[] data = decode(content);

		long maxSize = ((Long) conf.get("maxSize")).longValue();

		if (!validSize(data, maxSize)) {
			return new BaseState(false, AppInfo.MAX_SIZE);
		}

		String suffix = FileType.getSuffix("JPG");

		String savePath = PathFormat.parse((String) conf.get("savePath"),
				(String) conf.get("filename"));
		
		savePath = savePath + suffix;
		String physicalPath = (String) conf.get("rootPath") + savePath;

		State storageState = StorageManager.saveBinaryFile(data, physicalPath);

		if (storageState.isSuccess()) {
			storageState.putInfo("url", PathFormat.format(savePath));
			storageState.putInfo("type", suffix);
			storageState.putInfo("original", "");
			if(StringUtils.equals((String)conf.get("imageActionName"), "uploadimage")) {
				InputStream tempis = null;
				BufferedImage src = null;
				int height = -1;
				int width = -1;
				try {
					tempis = new FileInputStream(new File(physicalPath));
					src = javax.imageio.ImageIO.read(tempis);
					height = src.getHeight(null); // 得到源图高
					width = src.getWidth(null);
					tempis.close();
					tempis = null;
				} catch (Exception e) {
					e.printStackTrace();
				} finally {
					if(tempis != null) {
						IOUtils.closeQuietly(tempis);
					}
				}
				if(height > 0) {
					storageState.putInfo("height", height);
				}
				if(width > 0) {
					storageState.putInfo("width", width);
				}
			}
		}

		return storageState;
	}

	private static byte[] decode(String content) {
		return Base64.decodeBase64(content);
	}

	private static boolean validSize(byte[] data, long length) {
		return data.length <= length;
	}
	
}